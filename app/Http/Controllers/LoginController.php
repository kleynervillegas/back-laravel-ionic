<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\JWTAuth;
use JWTAuth;
use Log;
use DB;
use App\Models\User;
use App\traits\NotificationsTrait;

class LoginController extends Controller
{
    use NotificationsTrait;
    //body of request response 
    public $data;

    public function __construct()
    {
        $this->data = config('variablesGobla.data');
    }

    public function rules()
    {

        $rules = [
            'FullName' => 'required',
            'LastNames' => 'required',
            'NumberId' => 'required|unique:users',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|min:4',
            'email' => 'required|unique:users',
            'typeUser' => 'required',
            'typeNumberId' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'FullName.required' => 'campo requerido',
            'LastNames.required' => 'campo requerido ',
            'NumberId.required' => 'campo requerido',
            'NumberId.unique' => 'Cedula Repetida',
            'password.required' => 'campo requerido ',
            'email.required' => 'campo requerido',
            'email.unique' => 'Email Repetida',
            'typeUser.required' => 'campo requerido ',
            'typeNumberId.required' => 'campo requerido ',
            'password_confirmation.required' => 'Debe confirmar su contrasena ',
        ];
        return $messages;
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', strtolower($request->email))->first();
            if ($user != null) {
                if (decrypt($user->password)  === $request->password && $user->email === strtolower($request->email)) {
                    $token = JWTAuth::fromUser($user);
                    $status = 'success';
                    $code = 200;
                    $this->data['status'] = $status;
                    $this->data['code'] = $code;
                    $this->data['token'] = $token;
                    $this->data['tokenType'] = "bearer";
                    $this->data['expiresIn'] = auth()->factory()->getTTL() * 60;
                    $this->data['data'] = $user;
                    $this->data['message'] = "Autenticacion Correcta";
                    return $this->data;
                } else {
                    $this->data['message'] = "Autenticacion Incorrecta";
                    return $this->data;
                }
            }
            $this->data['message'] = "Usuario No Encontrado";
            return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }

    public function logout()
    {
        try {
            auth()->logout();
            $status = 'success';
            $code = 200;
            $this->data['status'] = $status;
            $this->data['code'] = $code;
            $this->data['message'] = "Sesion Finalizada";
            return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
    public function registre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules(), $this->messages());
            if ($validator->fails()) {
                return response()->json($validator->errors()->all(), 400);
            }
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'FullName' => $request->FullName,
                    'LastNames' => $request->LastNames,
                    'NumberId' => $request->NumberId,
                    'password' => encrypt($request->password),
                    'email' => strtolower($request->email),
                    'typeUser' => $request->typeUser,
                    'typeNumberId' => $request->typeUser,
                ]);
                $this->createNotification(0,0,0,'Bienvenido verifica tu cuenta para que puedas comezar con tus compras','regitro de user');
                $code = 200;
                $status = 'success';
                $this->data['status'] = $status;
                $this->data['data'] = $user;
                $this->data['code'] = $code;
                $this->data['message'] = "Usuario Registardo Satisfactoriomente";
                return $this->data;
            });
            return response()->json($this->data);
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
}
