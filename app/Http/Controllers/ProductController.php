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
        $products = Product::all()->load(['category', 'colors', 'sizes']);

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
            'size_id' => 'required|array|exists:sizes,id',
            'color_id' => 'required|array|exists:colors,id',
            'price' => 'required|integer',
            'sales_price' => 'sometimes|integer',
            'featured' => 'sometimes|boolean',
            'category_id' => 'required|integer|exists:categories,id'
        ]);

        $product = Product::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'product_image' => $validatedData['product_image'],
            'price' => $validatedData['price'],
            'sales_price' => $validatedData['sales_price'],
            'featured' => $validatedData['featured'],
            'category_id' => $validatedData['category_id']
        ])->load('category');

        $product->sizes()->attach($validatedData['size_id']);
        $product->colors()->attach($validatedData['color_id']);

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
