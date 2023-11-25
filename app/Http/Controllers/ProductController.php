<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    //

    public function getAllProducts()
    {
        $products = Product::all()->load('category');

        return response([
            "data" => $products
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::findOrFail($id)->load('category');

        return response([
            "data" => $product
        ]);
    }

    public function createProduct(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'product_image' => 'required|string',
            'size_id' => 'required|integer|exists:sizes,id',
            'colors' => 'required|string',
            'price' => 'required|integer',
            'featured' => 'sometimes|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $product = Product::create($validatedData)->load('category');

        return response([
            "data" => $product,
        ]);
    }


    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'product_image' => 'string',
            'size_id' => 'integer|exists:sizes,id',
            'colors' => 'string',
            'price' => 'integer',
            'featured' => 'boolean',
            'category_id' => 'integer|exists:categories,id'
        ]);

        $product = Product::findOrFail($id);

        $product->update($validatedData)->load('category');

        return response([
            "message" => "Product Updated Successfully",
            "data" => $product
        ]);
    }
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response([
            "message" => "product deleted"
        ]);
    }
}
