<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cars extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'count',           
        'id_product',
        'id_user',
    ];


    public function getProduct()
    {
        return $this->hasOne(Product::class, 'id', 'id_product');
    }
}
