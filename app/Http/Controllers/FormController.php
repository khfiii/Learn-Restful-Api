<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Requests\FormRequest;  
use App\Http\Controllers\API\BaseController;

class FormController extends BaseController
{

    public function index(Request $request)
    {
        try {

            if(!$request->user('sanctum')){
                return $this->errorResponse('Unaunthenticated User', codeStatus:401); 
            }

            $authUser = $request->user('sanctum');

            return $this->succesResponse('Succesfully retrieved forms data', [
                'data' => Form::select('name', 'slug', 'allowed_domains')
                ->where('user_id', $authUser->getKey())
                ->get(), 
            ]);
            
        } catch (\Exception $e) {
            logger($e);
            $this->errorResponse($e->getMessage()); 
        }
    }

    public function createForm(FormRequest $request)
    {

        try {

            if(!$request->user('sanctum')){
                return $this->errorResponse('Unaunthenticated User', codeStatus:401); 
            }

            $authUser = $request->user('sanctum');
            $name = $request->name; 
            $slug = $request->slug; 
            $allowedDomains = $request->allowed_domains; 
            $description = $request->description; 
            $limitOneResponse = $request->limit_one_response; 

            $createForm = $authUser->forms()->create([
                'name' => $name, 
                'slug' => $slug, 
                'allowed_domains' => $allowedDomains, 
                'description' => $description, 
                'limit_one_response' => $limitOneResponse
            ]); 

            return $this->succesResponse('Forms created succesfully', [
                'data' => $createForm, 
            ]); 



        } catch (\Exception $e) {

            logger($e);

            return $this->errorResponse($e);
        }
    }                       
}
