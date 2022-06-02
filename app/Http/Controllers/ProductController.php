<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use DB;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\Response;



class ProductController extends Controller
{
  //body of request response 
  public $data = [
    'status' => 'Error',
    'data' => array(),
    'code' => 400,
    'message' => 'A ocurrido un Error',
  ];

  public $imegenArray = [];
  public function rules()
  {
    $rules = [
      'name' => 'required|max:100',
      'description' => 'required|max:500',
      'coin' => 'required|max:1',
      'price' => 'required|numeric',
      'stopMin' => 'required|numeric',
      'stopMax' => 'required|numeric',
      'image' => array('required'),
    ];
    return $rules;
  }

  public function get_image($imgen)
  {

    try {
      $file = Storage::disk('image')->get($imgen);
      return $file;
    } catch (\Exception $exception) {
      return $this->data;
    }
  }

  public function index()
  {
    $products = Product::all();
    foreach ($products as $key => $product) {
      $imgen =  json_decode($product->image);
      $product['image'] = $imgen;
    }
    $code = 200;
    $status = 'success';
    $this->data['status'] = $status;
    $this->data['data'] = $products;
    $this->data['code'] = $code;
    $this->data['message'] = "Productos encontrados correctamente";
    return $this->data;
  }
  public function store(Request $request)
  {
    try {
      $validated = $request->validate($this->rules());
      $products = DB::transaction(function () use ($request) {
        foreach ($request->image as $file) {
          $file = $file;
          //la extension de los archivos
          $png = strstr($file, 'data:image/png;base64');
          $jpg = strstr($file, 'data:image/jpg;base64');
          $jpeg = strstr($file, 'data:image/jpeg;base64');
          if ($png != null) {
            $file = str_replace("data:image/png;base64,", "", $file);
            $file = base64_decode($file);
            $extension = ".png";
          } elseif ($jpeg != null) {
            $file = str_replace("data:image/jpeg;base64,", "", $file);
            $file = base64_decode($file);
            $extension = ".jpeg";
          } elseif ($jpg != null) {
            $file = str_replace("data:image/jpg;base64,", "", $file);
            $file = base64_decode($file);
            $extension = ".jpg";
          }
          $nameFile = uniqid() . $extension;
          file_put_contents(storage_path('app/image/') . $nameFile, $file);
          $this->imegenArray[] = $nameFile;
        }
        $products = Product::create([
          'name' => $request->name,
          'description' => $request->description,
          'coin' => $request->coin,
          'price' => $request->price,
          'stopMin' => $request->stopMin,
          'stopMax' => $request->stopMax,
          'image' => json_encode($this->imegenArray)
        ]);
        $code = 200;
        $status = 'success';
        $this->data['status'] = $status;
        $this->data['data'] = $products;
        $this->data['code'] = $code;
        $this->data['message'] = "Producto Registrado Satisfactoriamente";

        return $this->data;
      });
      return response()->json($this->data);
    } catch (\Exception $exception) {
      return $this->data;
    }
  }

  public function getDetailsProduct($id)
  {
    try {

      $product = Product::where('id', $id)->first();
      $imgen =  json_decode($product->image);
      $product['image'] = $imgen;
      $code = 200;
      $status = 'success';
      $this->data['status'] = $status;
      $this->data['data'] = $product;
      $this->data['code'] = $code;
      $this->data['message'] = "Producto encontrado correctamente";
      return $this->data;
    } catch (\Exception $exception) {
      return $this->data;
    }
  }
}
