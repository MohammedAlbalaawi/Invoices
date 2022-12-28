<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'section_id' => ['required'],
            'user_id' => ['required'],
            'product_id' => ['required'],
            'invoice_number' => ['required',Rule::unique('invoices','invoice_number')->ignore(optional($this->model)->id)],
            'invoice_Date' => ['required'],
            'due_date' => ['required'],
            'amount_collection' => ['required'],
            'amount_commission' => ['required'],
            'discount' => ['required'],
            'rate_vat' => ['required'],
            'value_vat' => ['required'],
            'total' => ['required'],
            'note' => ['nullable'],
            'status' => ['nullable'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,gif,webp'],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => Auth::user()->id
        ]);
    }
}
