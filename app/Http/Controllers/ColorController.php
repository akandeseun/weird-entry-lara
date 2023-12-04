<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{

    public function __construct(private ColorService $colorService)
    {
    }

    public function getAllColors()
    {
        $colors = $this->colorService->getAllColors();

        return response()->json($colors);
    }

    public function getColor($id)
    {
        $color = $this->colorService->getColor($id);

        return response()->json($color);
    }

    public function createColor(Request $request)
    {

        $result = $this->colorService->createColor($request);

        return response()->json([
            "message" => $result->message,
            "data" => $result->data
        ], 201);
    }

    public function updateColor(Request $request, $id)
    {
        $result = $this->colorService->updateColor($request, $id);

        return response()->json([
            "message" => $result->message,
            "data" => $result->data
        ]);
    }

    public function deleteColor($id)
    {
        $result = $this->colorService->deleteColor($id);

        return response()->json(["message" => $result->message]);
    }
}
