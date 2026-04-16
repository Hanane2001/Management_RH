<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEvaluationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isManager());
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
            'evaluation_date' => 'required|date',
            'period' => 'required|string|max:50',
            'overall_score' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Veuillez sélectionner un employé',
            'evaluation_date.required' => 'La date d\'évaluation est requise',
            'period.required' => 'La période est requise',
            'overall_score.required' => 'Le score est requis',
            'overall_score.min' => 'Le score doit être entre 0 et 100',
            'overall_score.max' => 'Le score doit être entre 0 et 100',
        ];
    }
}
