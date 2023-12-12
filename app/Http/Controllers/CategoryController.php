<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(private CategoryService $categoryService)
    {
    }
    public function getAllCategories()
    {
        $categories = $this->categoryService->getAllCategories();
        return response()->json($categories);
    }

    public function getCategory($id)
    {
        $category = $this->categoryService->getCategory($id);
        return response()->json($category);
    }

    public function createCategory(Request $request)
    {
        $result = $this->categoryService->createCategory($request);

        return response()->json([
            "message" => "Category created",
            "data" => $result->data
        ], 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $result = $this->categoryService->updateCategory($request, $id);

        return response()->json([
            "message" => "Category updated",
            "data" => $result->data
        ]);
    }

    public function deleteCategory($id)
    {
        $result = $this->categoryService->deleteCategory($id);

        return response()->json([
            "message" => $result->message,
        ], 201);
    }
}
