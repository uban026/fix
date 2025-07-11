<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
class UserCartController extends Controller
{
    public function index()
    {
        return view('landing.shopping-cart');
    }

    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $coupon = Coupon::where('name', $request->code)
            ->where('status', 'active')
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive coupon code.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $coupon->id,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'name' => $coupon->name
            ]
        ]);
    }
}
