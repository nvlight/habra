<?php

namespace App\Http\Requests;

use App\Enums\DifficultyEnum;
use App\Enums\PostStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
            'company_id' => 'nullable|exists:companies,id',
            'title' => 'required|string',
            'content' => 'nullable|string|max:65535',
            'difficulty' => ['nullable', Rule::enum(DifficultyEnum::class)],
            'read_time' => 'nullable|integer',

            //'views' => 'nullable|integer',
            //'likes' => 'nullable|integer',
            //'published_at' => 'nullable|date_format:Y-m-d H:i:s', //'date' => 'required|date_format:Y-m-d H:i:s',
            //'status' => ['nullable', Rule::enum(PostStatusEnum::class)],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        $validated['status'] = PostStatusEnum::DRAFT;

        return $validated;
    }
}
