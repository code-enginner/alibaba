<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => ['bail', 'required', 'string', 'min:3'],
            'content' => ['bail', 'required', 'string', 'min:5'],
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'title is required',
            'title.string' => 'title should be string format',
            'title.min' => 'title should have at lest 3 characters',
            'content.required' => 'content is required',
            'content.string' => 'content should be string format',
            'content.min' => 'content should have at lest 5 characters',
        ];
    }
}
