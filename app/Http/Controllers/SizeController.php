<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    //
    public function getAllSizes()
    {
        $sizes = Size::all();
        // $sizes->load('products');
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

        Validator::make($request->all(), [
            'title' => ['required', 'string', 'unique:sizes'],
            'description' => ['required', 'string']
        ])->validate();

        $size = Size::create([
            'title' => strtoupper($request->title),
            'description' => ucfirst($request->description)
        ]);

        return response([
            "message" => "Size created",
            "data" => $size
        ], 201);
    }

    public function updateSize(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => ['string', 'unique:sizes'],
            'description' => ['string']
        ])->validate();

        $size = Size::findOrFail($id);

        $size->update($request->all());

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
