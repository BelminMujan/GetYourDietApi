<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DietController extends Controller {
    public function requestDiet(Request $request){
        Log::Info($request->all());
    }
}