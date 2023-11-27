<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    public function getAllColors()
    {
        $colors = Color::all();
        // $colors->load('products');
        return response([
            "data" => $colors
        ]);
    }

    public function getColor($id)
    {
        $color = Color::findOrFail($id)->load('products');
        // $color->load('products');
        return response([
            "data" => $color
        ]);
    }

    public function createColor(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required', 'string', 'unique:colors'],
            'description' => ['required', 'string']
        ])->validate();

        $color = Color::create([
            'title' => strtoupper($request->title),
            'description' => ucfirst($request->description)
        ]);

        return response([
            "message" => "Color created",
            "data" => $color
        ], 201);
    }

    public function updateColor(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'string',
            'description' => 'string'
        ]);

        $color = Color::findOrFail($id);

        $color->update($validatedData);

        return response([
            "message" => "Color updated",
            "data" => $color
        ]);
    }

    public function deleteColor($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return response([
            "message" => "Color Deleted"
        ]);
    }
}
