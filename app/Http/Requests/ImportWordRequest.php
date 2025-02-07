<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ImportWordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'url' => 'required_without:file|url',
            'file' => 'required_without:url|file|mimes:json',
        ];
    }

    public function attributes(): array
    {
        return [
            'url' => __('field.url'),
            'file' => __('field.file'),
        ];
    }
}
