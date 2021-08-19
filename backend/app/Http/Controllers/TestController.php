<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    
    public function test1()
{   
    return response()->json([
        'result' => 'Response from Laravel',
    ]); 
}
}
