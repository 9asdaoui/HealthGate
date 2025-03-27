<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'time_slot' => 'required|string',
            'reason' => 'required|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor',
            'doctor_id.exists' => 'The selected doctor does not exist',
            'appointment_date.required' => 'Please select an appointment date',
            'appointment_date.date' => 'The selected appointment date is invalid',
            'time_slot.required' => 'Please select a time slot',
            'time_slot.string' => 'The selected time slot is invalid',
            'reason.required' => 'Please provide a reason for the appointment',
            'reason.string' => 'The reason must be a string'
        ];
    }
    
}
