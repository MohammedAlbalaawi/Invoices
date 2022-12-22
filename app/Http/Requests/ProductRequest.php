<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('products','name')->ignore(optional($this->model)->id)],
            'description' => ['nullable','string'],
            'section_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يرجي إدخال اسم المنتج',
            'name.unique' => 'هذا المنتج موجود مسبقا',
            'section_id.required' => 'يرجى اختيار القسم',
        ];
    }

}
