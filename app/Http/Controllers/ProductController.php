<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use DB;

class ProductController extends Controller
{
  //body of request response 
  public $data = [
    'status' => 'Error',
    'data' => array(),
    'code' => 400,
  ];

  public function rules()
  {
    $rules = [
      'name' => 'required|max:100',
      'description' => 'required|max:500',
      'price' => 'required|numeric',
      'stopMin' => 'required|numeric',
      'stopMax' => 'required|numeric',
      'image' => 'required',
    ];
    return $rules;
  }

  public function show(Request $reques, $id)
  {
    dd($id);
  }

  public function index(Request $reques, $id)
  {
    dd($id);
  }
  public function store(Request $request)
  {
    try {
      $validated = $request->validate($this->rules());
      $products = DB::transaction(function () use ($request) {
        $products = Product::create([
          'name' => $request->name,
          'description' => $request->description,
          'price' => $request->price,
          'stopMin' => $request->stopMin,
          'stopMax' => $request->stopMax,
          'image' => json_encode($request->image)
        ]);
        $code = 200;
        $status = 'success';
        $this->data['status'] = $status;
        $this->data['data'] = $products;
        $this->data['code'] = $code;
        return $this->data;
      });
      return response()->json($this->data);
    } catch (\Exception $exception) {
      return $this->data;
    }
  }
}
