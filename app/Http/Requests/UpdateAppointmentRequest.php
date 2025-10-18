<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Appointment::getUpdateValidationRules();
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->appointment,
        ]);
    }
}
