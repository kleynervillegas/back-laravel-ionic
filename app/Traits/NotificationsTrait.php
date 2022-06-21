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
    public function createNotification($product,$id_user,$id_user_origin,$description,$origin)
    {    
        
        $nofity = DB::transaction(function () use ($product,$id_user,$id_user_origin,$description,$origin) {               
            $nofity = Notification::create([
                'id_product' =>$product=0? 0 :$product->id,
                'id_user' => $id_user,
                'id_user_origin' =>$id_user_origin,
                'description' =>$product=0? $description :$description.' '.$product->name,
                'send_user' =>0,
                'origin' => $origin,    
              ]); 
            return $nofity;
        });
        return $nofity;
    } 
      
}