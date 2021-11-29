<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class userAuth extends FormRequest
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
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed"
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
            'name.required' => 'Please Enter Your Name',
            'email.required'  => 'Please Enter Your Email',
            'password.required'  => 'Please Enter Your Password',
            'name.string'  => 'Name Must Be in Characters',
            'email.string'  => 'Email Must Be in Characters',
            'password.string'  => 'Email Must Be in Characters',
            'email.unique'  => 'Email Must Be Unique',
            'password.confirmed'  => 'Please Enter Confirmed Password',
        ];
    }
}
