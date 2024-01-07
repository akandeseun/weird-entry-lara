<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{

    public function __construct(private SizeService $sizeService)
    {
    }

    public function getAllSizes()
    {
        $sizes = $this->sizeService->getAllSizes();

        return response()->json($sizes);
    }

    public function getSize($id)
    {
        $size = $this->sizeService->getSize($id);

        return response()->json($size);
    }

    public function createSize(Request $request)
    {

        $result = $this->sizeService->createSize($request);

        return response()->json([
            "message" => $result->message,
            "data" => $result->data
        ], 201);
    }

    public function updateSize(Request $request, $id)
    {
        $result = $this->sizeService->updateSize($request, $id);

        return response()->json([
            "message" => $result->message,
            "data" => $result->data
        ]);
    }

    public function deleteSize($id)
    {
        $result = $this->sizeService->deleteSize($id);

        return response()->json([
            "message" => $result->message
        ]);
    }
}
