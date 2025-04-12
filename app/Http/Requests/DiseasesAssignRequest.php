<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiseasesAssignRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'disease_id' => 'required|exists:diseases,id',
            'duration' => 'nullable|string|max:255',
        ];
    }
}
