<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiseaseRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|regex:/^[A-Za-z\s\-]+$/',
            'category' => 'required|string|in:viral,bacterial,fungal,parasitic,chronic',
            'description' => 'required|string',
            'symptoms' => 'required|string',
            'prevention' => 'nullable|string',
            'treatment' => 'nullable|string',
            'image' => 'nullable|string|url|max:2048',
        ];
    }
}
