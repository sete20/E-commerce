<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostsRquest extends FormRequest
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
            'post_title_en'=>'required|max:255',
            'post_title_ar'=>'required|max:255',
            'category_id'=>'required|numeric',
            'details_en'=>'required|max:255',
            'details_ar'=>'required|max:255',
        ];
    }
}
