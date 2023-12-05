<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
  public function getAllCategories()
  {
    $categories = Category::with(['products'])->get();

    return $categories;
  }

  public function getCategory($id)
  {
    $category = Category::with(['products'])->findOrFail($id);
    return $category;
  }

  public function createCategory(Request $request)
  {

    Validator::make($request->all(), [
      'title' => ['required', 'string'],
      'description' => ['required', 'string']
    ])->validate();

    $category = Category::create($request->all());

    return (object)[
      "message" => "Category created",
      "data" => $category
    ];
  }

  public function updateCategory(Request $request, $id)
  {
    Validator::make($request->all(), [
      'title' => ['string'],
      'description' => ['string']
    ])->validate();

    $category = $this->getCategory($id);

    $category->update($request->all());

    return (object)[
      "message" => "Category updated",
      "data" => $category
    ];
  }

  public function deleteCategory($id)
  {
    $category = $this->getCategory($id);
    $category->delete();

    return (object)[
      "message" => "Category Deleted"
    ];
  }
}
