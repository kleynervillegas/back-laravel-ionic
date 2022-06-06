<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Notification extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_product',
        'id_user',
        'descrption',
        'send_user',
        'origin',     
    ];
}