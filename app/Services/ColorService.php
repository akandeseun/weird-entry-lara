<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Color;
use Illuminate\Support\Facades\Validator;

class ColorService
{
  public function getAllColors()
  {
    $colors = Color::all();

    return $colors;
  }

  public function getColor($id)
  {
    $color = Color::findOrFail($id);

    return $color;
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

    return (object) [
      "message" => "Color created",
      "data" => $color
    ];
  }

  public function updateColor(Request $request, $id)
  {
    $validatedData = $request->validate([
      'title' => 'string',
      'description' => 'string'
    ]);

    $color = $this->getColor($id);

    $color->update($validatedData);

    return (object)[
      "message" => "Color updated",
      "data" => $color
    ];
  }

  public function deleteColor($id)
  {
    $color = $this->getColor($id);
    $color->delete();

    return (object) [
      "message" => "Color Deleted"
    ];
  }
}
