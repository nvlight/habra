<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'spokesperson_id' => 'required|exists:users,id',
            'title' => 'nullable|string',
            'site' => 'required|string',
            'numbers' => 'nullable|integer',
            'location' => 'nullable|string',
            'age_date' => 'nullable|date',
        ];
    }
}
