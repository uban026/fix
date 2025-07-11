<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class UserOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['items.product', 'coupon'])
            ->where('user_id', auth()->id())
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) => $q->where('order_code', 'like', "%$s%"))
            ->latest()
            ->paginate(10);

        $orders->getCollection()->transform(function ($order) {
            $discount = 0;

            if ($order->coupon && $order->coupon->status === 'active') {
                $total = $order->items->sum(fn($item) => $item->quantity * $item->price);
                if ($order->coupon->type === 'amount') {
                    $discount = $order->coupon->value;
                } elseif ($order->coupon->type === 'percent') {
                    $discount = ($order->coupon->value / 100) * $total;
                }
            }

            $order->total_pay = max(($order->total_amount) - $discount, 0);

            return $order;
        });


        return view('landing.order', compact('orders'));
    }

    /**
     * Cancel the specified order.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak diizinkan untuk melakukan aksi ini.');
        }

        // Validasi: Hanya status pending yang bisa dibatalkan
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pesanan yang menunggu pembayaran yang bisa dibatalkan.');
        }

        try {
            $order->updateStatus('cancelled');
            return redirect()->route('user.orders')->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment callback from Snap.js.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentSuccess(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            if ($order->status === 'pending') {
                $order->update([
                    'status' => 'paid',
                    'midtrans_transaction_id' => $request->input('transaction_id'),
                    'midtrans_payment_type' => $request->input('payment_type'),
                ]);
            }
            return response()->json(['message' => 'Payment status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update payment status.'], 500);
        }
    }
}
