<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //

    public function getAllProducts()
    {
        $products = Product::all();

        return response([
            "data" => $products
        ]);
    }

    public function getProduct($id)
    {
        $product = Product::findOrFail($id);

        return response([
            "data" => $product
        ]);
    }

    public function createProduct(Request $request)
    {

        Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'product_image' => ['required', 'string'],
            'size_id' => ['required', 'array', 'exists:sizes,id'],
            'color_id' => ['required', 'array', 'exists:colors,id'],
            'price' => ['required', 'integer'],
            'sales_price' => ['sometimes', 'integer'],
            'featured' => ['sometimes', 'boolean'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ])->validate();

        // $validatedData = $request->validate([]);

        $product = Product::create($request->all());

        // $product->with('category');

        $product->sizes()->attach($request->size_id);
        $product->colors()->attach($request->color_id);

        return response([
            "data" => $product,
        ]);
    }


    public function updateProduct(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['string'],
            'description' => ['string'],
            'product_image' => ['string'],
            'size_id' => ['array', 'exists:sizes,id'],
            'color_id' => ['array', 'exists:colors,id'],
            'price' => ['integer'],
            'sales_price' => ['sometimes', 'integer'],
            'featured' => ['sometimes', 'boolean'],
            'category_id' => ['integer', 'exists:categories,id']
        ])->validate();

        $product = Product::findOrFail($id);

        $product->update($request->all());

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
