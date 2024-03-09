<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    protected $stopOnFirstFailure = TRUE;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['bail', 'required', 'string', 'max:255'],
            'email'     => ['bail', 'required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'  => ['bail', 'required', 'confirmed', Rules\Password::defaults()],
        ];
    }
}
