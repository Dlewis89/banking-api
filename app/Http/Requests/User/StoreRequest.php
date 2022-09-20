<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed', Password::defaults()],
            'email' => ['required', 'string', 'unique:users', 'email:rfc,dns'],
            'type' => ['sometimes', Rule::in([
                'client',
                'staff'
            ])],
            'is_admin' => ['sometimes', 'boolean'],
        ];
    }
}
