<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productsRequest extends FormRequest
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
            'category_id'=>'required|numeric',
            'product_name'=>'required|string|min:3|max:20',
            'product_code'=>'required|string',
            'product_quantity'=>'required|numeric',
            'product_details'=>'required|string',
            'product_color'=>'required|string',
            'product_size'=>'required|string',
            'selling_price'=>'required|string',
            'image_one'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'image_two'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'image_three'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ];
    }
}
