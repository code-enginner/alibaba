<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'email'    => ['bail', 'required', 'string', 'email'],
            'password' => ['bail', 'required', 'min:8'],
        ];
    }


    public function messages(): array
    {
        return [
            'email.required' => 'ایمیل اجباری است',
            'email.string' => 'فرمت ایمیل اشتباه است',
            'email.email' => 'نوع ایمیل صحیح نیست',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.min' => 'رمز عبور حداقل باید 8 حرف داشته باشد',
        ];
    }
}
