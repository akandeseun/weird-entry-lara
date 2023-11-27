<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    public function __construct(private ProductService $productService)
    {
    }
    //

    public function getAllProducts()
    {
        $products = $this->productService->getAllProducts();

        return response()->json($products);
    }

    public function getProduct($id)
    {
        $product = $this->productService->getProduct($id);

        return response()->json($product);
    }

    public function createProduct(Request $request)
    {
        $product = $this->productService->createProduct($request);

        return response()->json($product, 201);
    }


    public function updateProduct(Request $request, $id)
    {
        $result = $this->productService->updateProduct($request, $id);

        return response()->json([
            "message" => $result->message,
            "data" => $result->data
        ]);
    }

    public function deleteProduct($id)
    {
        $result = $this->productService->deleteProduct($id);

        return response()->json(["message" => $result->message]);
    }
}
