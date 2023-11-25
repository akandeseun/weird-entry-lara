<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class SizeController extends Controller
{
    //
    public function getAllSizes()
    {
        $sizes = Size::all();
        $sizes->load('products');
        return response([
            "data" => $sizes
        ]);
    }

    public function getSize($id)
    {
        $size = Size::findOrFail($id)->load('products');
        // $size->load('products');
        return response([
            "data" => $size
        ]);
    }

    public function createSize(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:sizes',
            'description' => 'required|string'
        ]);

        $size = Size::create([
            'title' => strtoupper($validatedData['title']),
            'description' => ucfirst($validatedData['description'])
        ]);

        return response([
            "message" => "Size created",
            "data" => $size
        ], 201);
    }

    public function updateSize(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);

        $size = Size::findOrFail($id);

        $size->update($validatedData);

        return response([
            "message" => "Size updated",
            "data" => $size
        ]);
    }

    public function deleteSize($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return response([
            "message" => "Size Deleted"
        ]);
    }
}
