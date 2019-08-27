<?php

namespace App\Http\Requests\User;

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
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255|unique:users',
            'givenName' => 'required|alpha_dash|max:255',
            'familyName' => 'required|alpha_dash|max:255',
            'password' => 'required|string|min:8|confirmed',
            'created' => 'nullable|date',
        ];
    }
}
