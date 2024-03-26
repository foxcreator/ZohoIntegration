<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
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
            'ownerId' => 'required',
            'accountName' => 'required|min:1|max:180',
            'accountWebsite' => 'nullable|url:http,https',
            'accountPhone' => 'nullable|numeric|min:6'
        ];
    }
}
