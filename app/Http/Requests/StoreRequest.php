<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'name' => 'required|'.Rule::unique('stores','name')->ignore($this->id),
            'address' => 'required',
            'is_active' => 'required|boolean',
            'store_code' => 'required|' . Rule::unique('stores', 'store_code')->ignore($this->id),
            'type_of' => 'required',
            'image' => "image|mimes:jpg,png,jpeg,gif,svg",
            'author_id' => 'unique:users,id',
            'total_monthly_cost',
            'total_cost_per_year',
            'total_monthly_revenue',
            'total_annual_revenue'
        ];
    }
}
