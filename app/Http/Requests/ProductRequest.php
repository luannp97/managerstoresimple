<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|'. Rule::unique('products','name')->ignore($this->id),
            'status' => 'required',
            'description' => 'required',
            'import_price' => 'required',
            'price' => 'required',
            'store_id' => 'required',
            'product_code' =>
            'required|' . Rule::unique('products', 'product_code')->ignore($this->id),
            'product_type' => 'required',
            'sold',
            'total',
            'image' => "image|mimes:jpg,png,jpeg,gif,svg"
        ];
    }
}
