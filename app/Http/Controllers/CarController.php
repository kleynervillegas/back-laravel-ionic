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
                $code = 200;
                $status = 'success';
                $this->data['status'] = $status;
                // $this->data['data'] = $user;
                $this->data['code'] = $code;
                $this->data['message'] = "Producto Agregado al carrito Satisfactoriomente";
                return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
}
