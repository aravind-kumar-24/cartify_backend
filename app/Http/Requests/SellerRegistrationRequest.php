<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerRegistrationRequest extends FormRequest
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
            'mobile_number' => "required|digits:10|regex:/^[6-9]\d{9}$/",
            'password' => "string|required|min:10",
            'business_name' => "string|required|max:60",
            'business_type' => "integer|required",
            'business_address' => "string|required|max:255",
            'city' => "integer|required",
            'state' => "integer|required",
            'pincode' => 'required|digits:6'
        ];
    }

    public function messages()
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
            'mobile_number.regex' => 'Mobile Number must start with 6, 7, 8, or 9',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a string',
            'password.min' => 'Password must be at least 10 characters long',

            'business_name.required' => 'Business Name is required',
            'business_name.string' => 'Business Name must be a string',
            'business_name.max' => 'Business Name must be maximum 60 characters long',

            'business_type.required' => 'Business Type is required',
            'business_type.integer' => 'Business Type must be a valid selection',

            'business_address.required' => 'Business Address is required',
            'business_address.string' => 'Business Address must be a string',
            'business_address.max' => 'Business Address must be maximum 255 characters long',

            'city.required' => 'City is required',
            'city.integer' => 'City must be a valid selection',

            'state.required' => 'State is required',
            'state.integer' => 'State must be a valid selection',

            'pincode.required' => 'Pincode is required',
            'pincode.digits' => 'Pincode must be exactly 6 digits',
        ];
    }
}
