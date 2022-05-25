<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
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
        // $this->middleware('auth:api', ['except' => ['login','authentication.store']]);
    }

    public function rules()
    {

        $rules = [
            'FullName' => 'required',
            'LastNames' => 'required',
            'NumberId' => 'required|unique:users',
            'password' => 'required',
            'Email' => 'required|unique:users',
            'User' => 'required',
            'typeUser' => 'required',
        ];
      
        return $rules;
    }

    public function messages(){
        $messages =[
            'FullName.required' => 'campo requerido',
            'LastNames.required' => 'campo requerido ',
            'NumberId.required' => 'campo requerido',
            'NumberId.unique:users' => 'Cedula Repetida',
            'password.required' => 'campo requerido ',
            'Email.required' => 'campo requerido',
            'Email.unique:users' => 'Email Repetida',
            'User.required' => 'campo requerido ',
            'typeUser.required' => 'campo requerido ',
        ];
        return $messages;
    }

    public function login(Request $request)
    {
        Log::info($request);
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

        // try {
        //     $user = User::where('Email', $request->email)->first();
        //     if ($user != null) {
        //         if (decrypt($user->Password) === $request->password && $user->Email === $request->email) {
        //             $status = 'success';
        //             $code = 200;
        //             $this->data['status'] = $status;
        //             $this->data['code'] = $code;
        //             $this->data['message'] = "Autenticacion Correcta";
        //             return $this->data;
        //         } else {
        //             $this->data['message'] = "Autenticacion Incorrecta";
        //             return $this->data;
        //         }
        //     }
        //     return $this->data;
        // } catch (\Throwable $th) {
        //     return $this->data;
        // }
    }
    public function store(Request $request)
    {     
        try {
            $validator = Validator::make($request->all(),$this->rules(),$this->messages());
            if ($validator->fails()){
                return response()->json($validator->messages(), 400);
            }
            $user = DB::transaction(function () use ($request) {
                $user = User::create([
                    'FullName' => $request->FullName,
                    'LastNames' => $request->LastNames,
                    'NumberId' => $request->NumberId,
                    'password' => encrypt($request->password),
                    'Email' => $request->Email,
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
}
