<?php

namespace App\Traits;

use DB;
use Illuminate\Http\Request;
use App\Models\Notification;
use Log;


trait NotificationsTrait
{   
    /**
    Función para crear las notificaciones
     */ 
    public function createNotification($active=false,$product,$id_user,$id_user_origin,$description,$origin,$first_notify=null)
    {  
        $nofity = DB::transaction(function () use ($active,$product,$id_user,$id_user_origin,$description,$origin,$first_notify) {               
            $nofity = Notification::create([
                'id_product' =>($active)? null :$product->id,
                'id_user' =>($active)? null :$id_user ,
                'id_user_origin' =>($active)? null :$id_user_origin,
                'description' =>($active)? $description :$description.' '.$product->name,
                'send_user' =>false,
                'origin' => $origin,    
                'first_notify' => $first_notify,
                'view_notify' => false,
              ]); 
            return $nofity;
        });
        return $nofity;
    } 
      
}