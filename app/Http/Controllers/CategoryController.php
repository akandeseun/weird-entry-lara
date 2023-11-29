<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAllCategories()
    {
        $categories = Category::with(['products'])->get();
        return response([
            "data" => $categories
        ]);
    }

    public function getCategory($id)
    {
        $category = Category::with(['products'])->findOrFail($id);
        return response([
            "data" => $category
        ]);
    }

    public function createCategory(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        $category = Category::create($validatedData);

        return response([
            "message" => "Category created",
            "data" => $category
        ], 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);

        $category = Category::findOrFail($id);

        $category->update($validatedData);

        return response([
            "message" => "Category updated",
            "data" => $category
        ]);
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response([
            "message" => "Category Deleted"
        ]);
    }
}
