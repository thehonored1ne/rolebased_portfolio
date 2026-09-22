<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role' => ['required', 'string', 'max:150'],
            'company' => ['required', 'string', 'max:150'],
            'period' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
