<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        try {
            $coupons = Coupon::query()
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search;
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('value', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('admin.coupon', compact('coupons'));
        } catch (Exception $e) {
            return back()->with('error', 'Failed to load coupons: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validasi input sesuai dengan struktur database yang benar
            $validated = $request->validate([
                'name' => 'required|max:255|unique:coupons,name',
                'type' => 'required|in:amount,percent', // menggunakan type sesuai database
                'value' => 'required|numeric|min:0', // value sesuai dengan potongan
                'status' => 'required|in:active,deactive',
            ]);

            Coupon::create($validated);

            DB::commit();

            return redirect()->route('admin.coupon')
                ->with('success', 'Coupon created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Failed to create coupon: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Coupon $coupon)
    {
        try {
            DB::beginTransaction();

            // Validasi input sesuai dengan struktur database yang benar
            $validated = $request->validate([
                'name' => 'required|max:255|unique:coupons,name,' . $coupon->id,
                'type' => 'required|in:amount,percent', // menggunakan type sesuai database
                'value' => 'required|numeric|min:0', // value sesuai dengan potongan
                'status' => 'required|in:active,deactive',
            ]);

            $coupon->update($validated);

            DB::commit();

            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Failed to update coupon: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Coupon $coupon)
    {
        try {
            DB::beginTransaction();

            $coupon->delete();

            DB::commit();

            return redirect()->route('admin.coupons.index')
                ->with('success', 'Coupon deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
