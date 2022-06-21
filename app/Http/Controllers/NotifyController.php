<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotifyController extends Controller
{

    public $data;

    public function __construct()
    {
        $this->data = config('variablesGobla.data');
    }


    public function getNotifyUser($id){
        try {
            $notification=  Notification::where('id_user',$id)->get();
                $code = 200;
                $status = 'success';
                $this->data['status'] = $status;
                $this->data['code'] = $code;
                $this->data['data'] = $notification;
                $this->data['message'] = "noticaciones del usuario";
                return $this->data;
        } catch (\Throwable $th) {
            return $this->data;
        }
    }
}
