<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductService
{
  public function getAllProducts(Request $request)
  {

    // ToDo Refactor Filter logic

    $category = $request->category;
    $price = $request->price;
    $search = $request->s;


    $products = Product::with(['category'])->latest();
    // category and price filter
    if ($category && $price) {

      $price = Str::of($price)->explode('-');
      $categories = Str::of($category)->explode('+');

      return $products
        ->where('category_id', '=', $category)
        ->orWhereIn('category_id', $categories)
        ->whereBetween('price', [$price[0], $price[1]])
        ->orWhereBetween('sales_price', [$price[0], $price[1]])->get();
    }
    // category filter
    if ($category) {

      $categories = Str::of($category)->explode('+');

      return $products
        ->where('category_id', '=', $category)
        ->orWhereIn('category_id', $categories)
        ->get();
    }
    // price filter
    if ($price) {

      $price = Str::of($price)->explode('-');

      return $products
        ->whereBetween('price', [$price[0], $price[1]])
        ->orWhereBetween('sales_price', [$price[0], $price[1]])->get();
    }

    // search filter 
    if ($search) {
      $products = $products->where('title', 'LIKE', "%{$search}%")
        ->orWhereHas('category', function (Builder $query) use ($search) {
          $query->where('title', 'LIKE', "%{$search}%");
        })->get();

      if ($products->count() < 1) {
        return (object)[
          "message" => "sorry we couldn't find what you were looking for"
        ];
      }

      return $products;
    }

    return $products
      ->paginate(10);
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

    $product = $this->getProduct($id);

    $product->delete();

    return (object) [
      "message" => "Product deleted"
    ];
  }
}
