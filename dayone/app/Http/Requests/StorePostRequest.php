<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxPostsPerUser;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'unique:posts,title', new MaxPostsPerUser()],
            'description' => ['required', 'string', 'min:10'],
            'image' => ['nullable', 'image', 'max:2048'],
            'tags' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.min' => 'Title must be at least 3 characters.',
            'title.unique' => 'This title has already been taken.',
            'description.required' => 'Description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'image.image' => 'The file must be an image.',
            'image.max' => 'Image size must not exceed 2MB.',
            'tags.string' => 'Tags must be a string.',
        ];
    }
}
