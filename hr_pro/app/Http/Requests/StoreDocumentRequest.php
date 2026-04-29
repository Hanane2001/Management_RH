<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth()->user();
        if ($user->isAdmin() || $user->isManager()) {
            return true;
        }
        
        if ($user->isEmployee()) {
            return $this->employee_id == $user->id;
        }
        
        return false;
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
            'type' => 'required|in:cv,contract,attestation,other',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:5120', // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Please select an employee',
            'type.required' => 'Please select the document type',
            'document.required' => 'Please select a file',
            'document.mimes' => 'The file must be of type: pdf, doc, docx, jpg, png',
            'document.max' => 'The file must not exceed 5MB',
        ];
    }
}
