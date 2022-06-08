<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use Log;
use DB;

class CarController extends Controller
{
    public function add_card($id){

        Log::info($id);

    }
}
