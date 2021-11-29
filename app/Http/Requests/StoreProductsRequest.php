<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductsRequest extends FormRequest
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
            "name" => "required",
            "description" => "required",
            "price" => "required",
            "qty" => "required",
            "image" => "required"
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
            'name.required' => 'Please Enter Product Name',
            'description.required'  => 'Please Enter Product Description',
            'price.required'  => 'Please Enter Product price',
            'qty.required'  => 'Please Enter Product qty',
            "image.required" => "image is required"
        ];
    }
}
