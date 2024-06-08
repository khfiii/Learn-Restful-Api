<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as FormRequestCustom;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormRequest extends FormRequestCustom
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required', 
            'slug' => 'required|unique:forms,slug|alpha_dash|', 
            'allowed_domains' => 'array', 
        ];
    }


    protected function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
        'message' => $validator->errors()
       ], 422)); 
    }

    


}
