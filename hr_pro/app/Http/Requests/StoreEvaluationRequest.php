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
            'employee_id.required' => 'Please select an employee',
            'evaluation_date.required' => 'The evaluation date is required',
            'period.required' => 'The period is required',
            'overall_score.required' => 'The score is required',
            'overall_score.min' => 'The score must be between 0 and 100',
            'overall_score.max' => 'The score must be between 0 and 100',
        ];
    }
}
