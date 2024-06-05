<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;



class BaseController extends Controller
{

    public function succesResponse(?string $message, $data = [], $codeStatus = 200)
    {
          
        $response['message'] = $message; 

        if(!empty($data)){
            $response['user'] = $data; 
        }

        return response()->json($response, $codeStatus);
        
    }
    public function errorResponse(?string $message, $codeStatus = 400)
    {
        return response()->json([
            "message" => $message,
        ], $codeStatus);
    }
}
