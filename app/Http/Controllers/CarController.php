<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use Log;
use DB;

class CarController extends Controller
{
    //body of request response 
    public $data;

    public function __construct()
    {
        $this->data = config('variablesGobla.data');
    }
    public function add_card(Request $request)
    {
        try {
            $car = DB::transaction(function () use ($request) {
                $car = Cars::create([
                    'count' => $request->count,
                    'id_product' => $request->id,
                    'id_user' => auth()->user()->id,
                ]);
                $code = 200;
                $status = 'success';
                $this->data['status'] = $status;
                $this->data['data'] = $car;
                $this->data['code'] = $code;
                $this->data['message'] = "Producto Agregado al carrito Satisfactoriomente";
                return $this->data;
            });
            return response()->json($this->data);
        } catch (\Throwable $th) {
            return $this->data;
        }
    }

    public function getCarUser(Request $request)
    {

        try {
            $car = DB::transaction(function () use ($request) {
                $car = Cars::where('id_user', auth()->user()->id)
                    ->with('getProduct')
                    ->get();

                foreach ($car as $value) {
                    $imgen =  json_decode($value->getProduct->image);
                    $value->getProduct['imageDecode'] = $imgen;
                }

                $code = 200;
                $status = 'success';
                $this->data['status'] = $status;
                $this->data['data'] = $car;
                $this->data['code'] = $code;
                $this->data['message'] = "car user";
                return $this->data;
            });
            return response()->json($this->data);
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
}
