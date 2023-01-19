<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'type' => ['required', 'string', Rule::in(['client', 'staff'])],
            'isAdmin' => 'required|boolean'
        ];
    }
}
