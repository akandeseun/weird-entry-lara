<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request)
    {
        Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
        ])->validate();

        $wishlist = Wishlist::create([
            "user_id" => Auth::id(),
            "product_id" => $request->product_id
        ]);

        return response()->json([
            "message" => "Product added to wishlist",
            $wishlist
        ], 201);
    }

    public function removeFromWishlist(Request $request)
    {
        $user = Auth::id();
        Validator::make($request->all(), [
            'product_id' => ['required', 'exists:products,id'],
        ])->validate();

        Wishlist::where('user_id', $user)
            ->where('product_id', $request->product_id)->delete();

        return response()->json([
            "message" => "item deleted from wishlist"
        ]);
    }

    public function getCurrentUserWishlist()
    {
        $user = Auth::id();

        $wishlists = Wishlist::with(['products', 'users'])->where('user_id', $user)->get();

        if ($wishlists->isEmpty()) {
            return response()->json(["message" => "Empty Wishlist"]);
        }

        return response()->json($wishlists);
    }
}
