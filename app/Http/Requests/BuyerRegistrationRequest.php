<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class BuyerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => "string|required|max:25",
            'last_name' => "string|required|max:25",
            'email_id' => "email|required",
            'mobile_number' => "required|digits:10",
            'password' => "string|required|min:10"
        ];
    }

    #[Override]
    public function messages():array
    {
        return [
            'first_name.required' => 'First Name is required',
            'first_name.string' => 'First Name must be a string',
            'first_name.max' => 'First Name must be maximum 25 characters long',

            'last_name.required' => 'Last Name is required',
            'last_name.string' => 'Last Name must be a string',
            'last_name.max' => 'Last Name must be maximum 25 characters long',

            'email_id.required' => 'Email ID is required',
            'email_id.email' => 'Invalid Email format',

            'mobile_number.required' => 'Mobile Number is required',
            'mobile_number.digits' => 'Mobile Number must be exactly 10 digits',

            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 10 characters long',
        ];
    }
}
