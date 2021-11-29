<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class userLoginAuth extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "required|string",
            "password" => "required|string"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = ['status' => "failed", "msg" => $validator->errors()];
        throw new HttpResponseException(response()->json($response, 422));
    }
    public function messages()
    {
        return [
            'email.required'  => 'Please Enter Your Email',
            'password.required'  => 'Please Enter Your Password',
            'email.string'  => 'Email Must Be in Characters',
            'password.string'  => 'Email Must Be in Characters',
        ];
    }
}
