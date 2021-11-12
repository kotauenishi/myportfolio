<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'item_name'=>['required'],
            'title'=>['required'],
            'count'=>['required','numeric'],
            'price'=>['required','numeric'],
            
        ];
    }

    public function messages(){
        return[
            'item_name.required'=>'必ず入力してください',
            'title.required'=>'必ず入力してください',
            'count.required'=>'必ず入力してください',
            'price.required'=>'必ず入力してください',
            'price.numeric'=>'数値を入力してください',
            'count.numeric'=>'数値を入力してください',
        ];
    }
}
