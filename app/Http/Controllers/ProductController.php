<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    //

    public function storeImage(Request $request)
    {
        $request->file('file')->store('images');

        return response(["message" => "Stored image"]);
    }

    public function uploadImageToCloudinary(Request $request)
    {

        $result = $request->file->storeOnCloudinaryAs('products', 'prod-1');
        $url = $result->getSecurePath();

        return response(["message" => "successful", "data" => $url]);
    }

    public function uploadImage($file, $oldURL = '')
    {
        if ($file) {
            $response = Http::withHeaders([
                'X-Requested-With' => 'XMLHttpRequest'
            ])->post('https://api.cloudinary.com/v1_1/dvik3nrfv/image/upload', [
                'file' => $file,
                'upload_preset' => $_ENV['CLOUDINARY_UPLOAD_PRESET']
            ]);

            return $response;
        }

        return ['url' => $oldURL];
    }

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
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'product_image' => 'required|string',
            'sizes' => 'required|string',
            'colors' => 'required|string',
            'price' => 'required|integer',
            'featured' => 'sometimes|boolean'
        ]);

        $product = Product::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'sizes' => $validatedData['sizes'],
            'colors' => $validatedData['colors'],
            'price' => $validatedData['price'],
            'product_image' => $validatedData['product_image']
        ]);


        return response([
            "data" => $product,
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

    public function updateProduct(Request $request, $id)
    {
    }
}
