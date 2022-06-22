<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Log;
class NotifyController extends Controller
{

    public $data;

    public function __construct()
    {
        $this->data = config('variablesGobla.data');
    }


    public function getNotifyUser($id){
          try {
            $first_notify= Notification::where('first_notify',true);
            $notification=  Notification::where('id_user_origin',$id)
            ->where('send_user',0)
            ->union($first_notify)->get();
            if($first_notify!=null){$first_notify->update(['first_notify' =>false]);}          
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
