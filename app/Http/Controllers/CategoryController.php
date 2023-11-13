<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response([
            "data" => $categories
        ]);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response([
            "data" => $category
        ]);
    }

    public function store(Request $request)
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

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response([
            "message" => "Category Deleted"
        ]);
    }
}
