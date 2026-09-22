<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'in:Frontend,Backend,DevOps,Tools,Other'],
            'icon' => ['nullable', 'string', 'max:50'],
            'proficiency' => ['required', 'integer', 'min:0', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
        ];
    }
}
