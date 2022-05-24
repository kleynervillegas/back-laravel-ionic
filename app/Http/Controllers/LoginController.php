<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;
use App\Models\User;

class LoginController extends Controller
{
    //body of request response 
    public $data = [
        'status' => 'Error',
        'data' => array(),
        'code' => 400,
        'message' => 'A ocurrido un Error',
    ];

    public function validateUser(Request $request)
    {
        try {
            $user = User::where('Email', $request->email)->first();
            if ($user != null) {
                if ($user->Password === $request->password && $user->Email === $request->email) {
                    $status = 'success';
                    $code = 200;
                    $this->data['status'] = $status;
                    $this->data['code'] = $code;
                    $this->data['message'] = "Autenticacion Correcta";
                    return $this->data;
                } else {
                    $this->data['message'] = "Autenticacion Incorrecta";
                    return $this->data;
                }
            }
            return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
}
