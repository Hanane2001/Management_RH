<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluationRequest extends FormRequest
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
            'employee_id' => 'sometimes|exists:users,id',
            'evaluation_date' => 'sometimes|date',
            'period' => 'sometimes|string|max:50',
            'overall_score' => 'sometimes|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:1000'
        ];
    }
}
