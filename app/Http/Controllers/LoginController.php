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


class LoginController extends Controller
{
    //body of request response 
    public $data = [
        'status' => 'Error',
        'data' => array(),
        'code' => 400,
        'message' => 'A ocurrido un Error',
    ];

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'registre']]);
    }

    public function rules()
    {

        $rules = [
            'FullName' => 'required',
            'LastNames' => 'required',
            'NumberId' => 'required|unique:users',
            'password' => 'required',
            'email' => 'required|unique:users',
            'User' => 'required',
            'typeUser' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'FullName.required' => 'campo requerido',
            'LastNames.required' => 'campo requerido ',
            'NumberId.required' => 'campo requerido',
            'NumberId.unique:users' => 'Cedula Repetida',
            'password.required' => 'campo requerido ',
            'email.required' => 'campo requerido',
            'email.unique:users' => 'Email Repetida',
            'User.required' => 'campo requerido ',
            'typeUser.required' => 'campo requerido ',
        ];
        return $messages;
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                if (decrypt($user->password)  === $request->password && $user->email === $request->email) {
                    $token = JWTAuth::fromUser($user);
                    $status = 'success';
                    $code = 200;
                    $this->data['status'] = $status;
                    $this->data['code'] = $code;
                    $this->data['token'] = $token;
                    $this->data['token_type'] = "bearer";
                    $this->data['expires_in'] = auth()->factory()->getTTL() * 60;
                    $this->data['message'] = "Autenticacion Correcta";
                    return $this->data;
                } else {
                    $this->data['message'] = "Autenticacion Incorrecta";
                    return $this->data;
                }
            }
            // return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
    public function registre(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->rules(), $this->messages());
            if ($validator->fails()) {
                return response()->json($validator->messages(), 400);
            }
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'FullName' => $request->FullName,
                    'LastNames' => $request->LastNames,
                    'NumberId' => $request->NumberId,
                    'password' => encrypt($request->password),
                    'email' => $request->email,
                    'User' => $request->User,
                    'typeUser' => $request->typeUser,
                ]);

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
