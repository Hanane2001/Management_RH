<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin() || auth()->user()->isManager();
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
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
            'base_salary' => 'required|numeric|min:0',
            'overtime_hours' => 'nullable|integer|min:0',
            'bonuses' => 'nullable|numeric|min:0',
            'allowances' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,generated,approved,paid'
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Veuillez sélectionner un employé',
            'month.required' => 'Le mois est requis',
            'year.required' => 'L\'année est requise',
            'base_salary.required' => 'Le salaire de base est requis',
            'base_salary.min' => 'Le salaire de base doit être positif',
        ];
    }
}
