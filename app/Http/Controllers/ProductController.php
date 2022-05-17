<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use DB;

class ProductController extends Controller
{
  public function __invoke()
  {
    dd("Dff");
  }

  public function show(Request $reques, $id)
  {
    return response()->json(Product::all());
  }

  public function index(Request $reques)
  {
    return response()->json(Product::all());
  }
  public function store(Request $request)
  {
    $status=500;
    $data= ['',$status];
    $data = DB::transaction(function () use ($request) {
      $products = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stopMin' => $request->stopMin,
        'stopMax' => $request->stopMax,
        'image' => json_encode($request->image),

      ]);
      $status=200;
      return $data =[$products,$status];
    });
    return response()->json($data[0], $data[1]); 

  }
}
