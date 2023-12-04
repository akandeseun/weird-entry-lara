<?php

namespace App\Services;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SizeService
{
  //
  public function getAllSizes()
  {
    $sizes = Size::all();

    return $sizes;
  }

  public function getSize($id)
  {
    $size = Size::findOrFail($id);

    return $size;
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

    return (object)[
      "message" => "Size created",
      "data" => $size
    ];
  }

  public function updateSize(Request $request, $id)
  {
    Validator::make($request->all(), [
      'title' => ['string', 'unique:sizes'],
      'description' => ['string']
    ])->validate();

    $size = $this->getSize($id);

    $size->update($request->all());

    return (object)[
      "message" => "Size updated",
      "data" => $size
    ];
  }

  public function deleteSize($id)
  {
    $size = $this->getSize($id);

    $size->delete();

    return (object)[
      "message" => "Size Deleted"
    ];
  }
}
