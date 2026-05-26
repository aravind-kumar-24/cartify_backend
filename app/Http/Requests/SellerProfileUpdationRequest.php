<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellerProfileUpdationRequest extends FormRequest
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
            'mobile_number' => "required|digits:10",
            'profile_pic' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages():array
    {
        return [
            'first_name.required' => 'First Name is required',
            'first_name.string' => 'First Name must be a string',
            'first_name.max' => 'First Name must be maximum 25 characters long',

            'last_name.required' => 'Last Name is required',
            'last_name.string' => 'Last Name must be a string',
            'last_name.max' => 'Last Name must be maximum 25 characters long',

            'mobile_number.required' => 'Mobile Number is required',
            'mobile_number.digits' => 'Mobile Number must be exactly 10 digits',

            'profile_pic.image' => 'Profile Picture must be an image',
            'profile_pic.mimes' => 'Only JPG, JPEG and PNG files are allowed',
            'profile_pic.max' => 'Profile Picture must not exceed 2MB',

        ];
    }
}
