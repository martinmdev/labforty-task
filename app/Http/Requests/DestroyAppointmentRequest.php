<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class DestroyAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Appointment::getIdValidationRules();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->appointment,
        ]);
    }
}
