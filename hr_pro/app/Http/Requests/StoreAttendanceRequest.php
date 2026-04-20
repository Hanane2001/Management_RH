<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        return $user->isAdmin() || $user->isManager();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,late,half-day'
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Veuillez sélectionner un employé',
            'date.required' => 'La date est requise',
            'status.required' => 'Le statut est requis',
            'check_out.after' => 'L\'heure de départ doit être après l\'heure d\'arrivée',
        ];
    }
}
