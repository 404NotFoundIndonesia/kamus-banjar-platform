<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWordRequest extends FormRequest
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
            'word' => 'required|string|min:1|max:255',
            'letter' => 'required|string|min:1|max:1',
            'data' => 'nullable|array',
        ];
    }

    public function attributes(): array
    {
        return [
            'word' => __('field.word'),
            'letter' => __('field.letter'),
        ];
    }
}
