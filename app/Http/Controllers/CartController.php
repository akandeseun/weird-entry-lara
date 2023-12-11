<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function updateCart(Request $request)
    {
        Validator::make($request->all(), [
            'items' => ['required', 'array'],
            'items_amount' => ['required', 'integer'],
            'user_email' => ['required', 'email']
        ])->validate();

        $cart = Cart::updateOrCreate([
            'user_email' => $request->user_email,
            'purchased' => false
        ], $request->all());

        return response()->json($cart);
    }

    public function getUserCart(Request $request)
    {
        $cart = Cart::where('user_email', $request->email)->where('purchased', 'false')->firstOrFail();

        return response()->json($cart);
    }
}
