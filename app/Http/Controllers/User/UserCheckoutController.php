<?php

namespace App\Http\Controllers\User;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\OrderItem;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserCheckoutController extends Controller
{
    public function __construct()
    {
        try {
            $serverKey = config('midtrans.server_key');

            if (empty($serverKey)) {
                throw new Exception('Midtrans server key is not configured. Please check your .env file');
            }

            Config::$serverKey = $serverKey;
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.sanitize');
            Config::$is3ds = config('midtrans.enable_3ds');

            Log::info('Midtrans Configuration Loaded', [
                'isProduction' => Config::$isProduction,
                'isSanitized' => Config::$isSanitized,
                'is3ds' => Config::$is3ds
            ]);
        } catch (Exception $e) {
            Log::error('Midtrans configuration error: ' . $e->getMessage());
            // It's better to throw the exception here to halt execution if Midtrans isn't set up
            throw $e;
        }
    }

    public function process(Request $request): JsonResponse
    {
        // [FIX] Mengubah catch (Exception $e) menjadi catch (\Throwable $e)
        // Ini akan menangkap semua jenis error dan memastikan JsonResponse selalu dikembalikan.
        try {
            $request->validate([
                'coupon_id' => ['string'],
                'name' => ['required', 'string'],
                'phone' => ['required', 'string'],
                'shipping_address' => ['required', 'string'],
                'notes' => ['nullable', 'string'],
                'cart' => ['required', 'array'],
                'cart.*.size' => ['nullable', 'string']
            ]);

            DB::beginTransaction();

            $order = Order::create([
                'user_id' => auth()->id(),
                'shipping_address' => $request->shipping_address,
                'total_amount' => 0, // Akan di-update nanti
                'coupon_id' => $request->coupon_id,
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            $totalAmount = 0;
            $items = [];

            foreach ($request->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'size' => $item['size'] ?? null,
                ]);

                $totalAmount += ($item['price'] * $item['quantity']);

                $items[] = [
                    'id' => (string) $item['id'],
                    'price' => (int) $item['price'],
                    'quantity' => (int) $item['quantity'],
                    'name' => $item['name'] . ($item['size'] ? ' - ' . $item['size'] : '')
                ];
            }

            $shippingCost = 20000;
            $totalAmount += $shippingCost;

            $discount = 0;
            if (!empty($request->coupon_id)) {
                $coupon = Coupon::where('id', $request->coupon_id)
                    ->where('status', 'active')
                    ->first();

                if ($coupon) {
                    if ($coupon->type === 'amount') {
                        $discount = $coupon->value;
                    } elseif ($coupon->type === 'percent') {
                        // Diskon dihitung dari subtotal sebelum ongkir
                        $subtotal_produk = $totalAmount - $shippingCost;
                        $discount = ($coupon->value / 100) * $subtotal_produk;
                    }
                }
            }

            if ($discount > 0) {
                $items[] = [
                    'id' => 'discount_' . $request->coupon_id,
                    'price' => -1 * (int) round($discount),
                    'quantity' => 1,
                    'name' => 'Discount'
                ];
            }

            $totalPay = max($totalAmount - $discount, 0);
            $order->update(['total_amount' => $totalAmount]);

            $params = [
                'transaction_details' => [
                    'order_id' => (string) $order->order_code, // Menggunakan order_code yang unik
                    'gross_amount' => (int) round($totalPay),
                ],
                'item_details' => array_merge($items, [
                    [
                        'id' => 'shipping_cost',
                        'price' => $shippingCost,
                        'quantity' => 1,
                        'name' => 'Shipping Cost'
                    ]
                ]),
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => auth()->user()->email,
                    'phone' => $request->phone,
                    'shipping_address' => [
                        'address' => $request->shipping_address
                    ]
                ]
            ];

            $snapToken = Snap::getSnapToken($params);

            if (empty($snapToken)) {
                throw new Exception('Failed to generate Snap Token from Midtrans.');
            }

            $order->update(['snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ]);
        } catch (\Throwable $e) { // <-- Perubahan di sini
            DB::rollBack();
            Log::error('Checkout process error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage()
            ], 500); // Menggunakan status code 500 untuk error server
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'order_id' => 'required',
                'transaction_id' => 'sometimes|nullable|string',
                'payment_type' => 'sometimes|nullable|string',
                'status' => 'required|in:paid,pending,cancelled'
            ]);

            $order = Order::findOrFail($request->order_id);

            if ($order->user_id !== auth()->id()) {
                throw new Exception('Unauthorized access');
            }

            $order->update([
                'status' => $request->status,
                'midtrans_transaction_id' => $request->transaction_id,
                'midtrans_payment_type' => $request->payment_type
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Throwable $e) { // <-- Perubahan di sini juga untuk konsistensi
            Log::error('Error updating order status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
