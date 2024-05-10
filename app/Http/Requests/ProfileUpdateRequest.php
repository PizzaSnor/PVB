<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Het naamveld is verplicht.',
            'name.string' => 'Het naamveld moet een string zijn.',
            'name.max' => 'Het naamveld mag niet langer zijn dan 255 tekens.',
            'email.required' => 'Het e-mailveld is verplicht.',
            'email.string' => 'Het e-mailveld moet een string zijn.',
            'email.lowercase' => 'Het e-mailadres moet in kleine letters zijn.',
            'email.email' => 'Het e-mailadres is ongeldig.',
            'email.max' => 'Het e-mailveld mag niet langer zijn dan 255 tekens.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
        ];
    }
}
