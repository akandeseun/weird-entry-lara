<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function createCoupon(Request $request)
    {
        Validator::make($request->all(), [
            'code' => ['required', 'string', 'unique:coupons,code'],
            'discount_percentage' => ['required', 'decimal:2'],
            'expiration_date' => ['required', 'date']
        ])->validate();

        $coupon = Coupon::create([
            'code' => strtoupper($request->code),
            'discount_percentage' => $request->discount_percentage,
            'expiration_date' => $request->expiration_date
        ]);

        return response()->json(["message" => "coupon created", $coupon], 201);
    }

    public function findCoupon($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);

        return response()->json($coupon);
    }

    public function editCoupon(Request $request, $couponId)
    {
        Validator::make($request->all(), [
            'discount_percentage' => ['sometimes', 'decimal:2'],
            'expiration_date' => ['sometimes', 'date']
        ])->validate();

        $coupon = Coupon::findOrFail($couponId);
        $coupon->update($request->all());

        return response()->json(["message" => "coupon updated", $coupon], 200);
    }

    public function deleteCoupon($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);

        $coupon->delete();

        return response()->json(["message" => "coupon deleted"]);
    }
}
