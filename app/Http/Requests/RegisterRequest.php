<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'user_name' => 'required|unique:users|max:30',
            'email' => 'required|unique:users|email',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'phone_number' => 'required',
            'password' => 'required',
            'address' => 'required',
            'image',
            'status'
        ];
    }
}
