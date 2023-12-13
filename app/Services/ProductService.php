<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductService
{
  public function getAllProducts(Request $request)
  {

    // ToDo Refactor Filter logic

    $category = $request->category;

    $price = Str::of($request->price);

    $products = Product::with(['category']);


    // Price and Category Filters

    if ($category && $price) {

      $price = $price->explode('-');

      $products
        ->latest()
        ->where('category_id', '=', $category)
        ->whereBetween('price', [$price[0], $price[1]])
        ->orWhereBetween('sales_price', [$price[0], $price[1]]);
    } elseif ($category) {

      $products
        ->where('category_id', '=', $category);
    } elseif ($price) {

      $price = $price->explode('-');

      $products = Product::with(['category'])
        ->whereBetween('price', [$price[0], $price[1]])
        ->orWhereBetween('sales_price', [$price[0], $price[1]]);
    } else {

      $products
        ->latest()
        ->paginate(10);
    }

    $products = $products->get();

    return $products;
  }

  public function getProduct($id)
  {
    $product = Product::with(['category', 'sizes'])->findOrFail($id);

    return $product;
  }

  public function searchProduct(Request $request)
  {
    // $searchQuery = $request->query('search');

    Validator::make($request->all(), [
      'search' => ['required', 'string']

    ])->validate();

    $product = Product::where('title', 'LIKE', "%{$request->search}%")->get();

    if ($product->count() < 1) {
      return (object)[
        "message" => "sorry we couldn't find what you were looking for"
      ];
    }

    return (object)[
      "message" => "Search results for {$request->search}",
      "data" => $product
    ];
  }

  // public function filterProductByCategory($categoryId)
  // {
  //   $products = Product::where('category_id', '=', $categoryId)->get();

  //   return $products;
  // }

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
