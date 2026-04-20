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
            'employee_id.required' => 'Veuillez sélectionner un employé',
            'type.required' => 'Veuillez sélectionner le type de document',
            'document.required' => 'Veuillez sélectionner un fichier',
            'document.mimes' => 'Le fichier doit être de type: pdf, doc, docx, jpg, png',
            'document.max' => 'Le fichier ne doit pas dépasser 5MB',
        ];
    }
}
