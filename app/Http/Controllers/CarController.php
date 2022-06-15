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
    public function add_card($id)
    {
        try {
            $car = DB::transaction(function () use ($id) {               
                $car = Cars::create([
                    'count' => 2,
                    'id_product' => $id,
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
}
