<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    use ValidationFailed;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules() : array
    {
        return [
            'name' => [ 'required', 'string', 'max:255', 'min:3' ],
	        'email' => [ 'required', 'email', 'unique:users' ],
	        'password' => [ 'required', 'min:8' ]
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'The name field is required',
            'name.string' => 'The name field must be a text',
            'name.max' => 'The name field exceeds the maximum size',
            'name.min' => 'The name field must be longer than three characters',
            'email.required' => 'The email field is required',
            'email.email' => 'The email is invalid',
            'email.unique' => 'The email must be unique',
            'password.required' => 'The password field is required',
            'password.min' => 'The password must be at least 8 characters long',
        ];
    }
}
