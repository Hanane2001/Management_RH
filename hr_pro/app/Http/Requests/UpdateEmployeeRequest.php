<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$this->route('id'),
            'phone' => 'nullable|string|min:10|max:15',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'id_number' =>'nullable|string',
            'social_security_number' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id'
        ];
    }
}
