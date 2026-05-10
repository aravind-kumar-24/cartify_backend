<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_type' => "string|required",
            'email_id' => "email|required",
            'password' => "string|required"
        ];
    }

    public function messages()
    {
        return [
            'user_type.required' => 'User Type is required',
            'user_type.string' => 'Invalid User Type',

            'email_id.required' => 'Email ID is required',
            'email_id.email' => 'Invalid Email format',

            'password.required' => 'Password is required',
        ];
    }
}
