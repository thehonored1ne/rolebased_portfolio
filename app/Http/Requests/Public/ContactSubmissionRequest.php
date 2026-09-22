<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class ContactSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
            // Honeypot field: must be empty if filled by humans
            'website_hp' => ['nullable', 'size:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'website_hp.size' => 'Bot activity detected.',
        ];
    }
}
