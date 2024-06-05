<?php

namespace App\Http\Controllers\API;


use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class AuthController extends BaseController
{

    public function register(AuthRequest $request){
       
        $data = array(
            'name' => $request->name, 
            'email' => $request->email,
            'password' => $request->password
        );

        $user = User::create($data); 
        $token = $user->createToken('register_token')->plainTextToken; 

        return $this->succesResponse('User created succesfully', [
            'details' => $user->only('name', 'email'), 
            'token' => $token
        ]); 


    }
    public function login(AuthRequest $request)
    {

        $data = array(
            'email' => $request->email,
            'password' => $request->password
        );

        if (!Auth::attempt($data)) {
            return $this->errorResponse('Credentials not match in our records');
        }

        $authenticatedUser = $request->user();
        $token = $authenticatedUser->createToken('myapp')->plainTextToken;
        $succes = array(
            'name' => $authenticatedUser->name,
            'email' => $authenticatedUser->email,
            'acces_token' => $token
        );

        return $this->succesResponse('Login succesfully', $succes);
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete(); // Revoke the current user's token
        
        return $this->succesResponse('Succesfully logout');
   
    }
}
