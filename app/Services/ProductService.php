<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductService
{
  public function getAllProducts()
  {
    $products = Product::with(['category', 'sizes'])->get();

    return $products;
  }

  public function getProduct($id)
  {
    $product = Product::with(['category', 'sizes'])->findOrFail($id);

    return $product;
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


    $product = Product::create($request->all());

    $product->sizes()->attach($request->size_id);
    $product->colors()->attach($request->color_id);

    return (object)[
      "message" => "Product created",
      "data" => $product
    ];
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

    $product = $this->getProduct($id);

    $product->update($request->all());

    return (object)[
      "message" => "Product updated",
      "data" => $product
    ];
  }

  public function deleteProduct($id)
  {
    // $product = Product::findOrFail($id);

    $product = $this->getProduct($id);

    $product->delete();

    return (object) [
      "message" => "Product deleted"
    ];
  }
}
