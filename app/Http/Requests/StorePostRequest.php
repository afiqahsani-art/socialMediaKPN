<?php

namespace App\Http\Requests;

//use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check(); // Only allow authenticated users to create posts
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'min:3', 'max:255'],
        ];
    }

    /**
     * Custom validation messages for post creation.
     */
    public function messages(): array
    {
        return [
            'content.required' => 'Sis, fill in the post content. Danke.',
            'content.string' => 'Must be string ah.',
            'content.min' => 'Min 3 characters.',
            'content.max' => 'Max is 255 ny.',
        ];
    }
}
