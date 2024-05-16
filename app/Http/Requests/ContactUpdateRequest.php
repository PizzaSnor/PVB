<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Je moet dit instellen op true als je wilt dat de gebruiker de aanvraag mag maken
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_email' => 'required|email|max:100',
            'contact_number' => 'required|string|max:50',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'contact_email.required' => 'Het contact e-mailadres is verplicht',
            'contact_email.max' => 'Het contact e-mailadres mag niet langer zijn dan :max tekens',
            'contact_email.email' => 'Het contact e-mailadres moet een geldig e-mailadres zijn',
            'contact_number.required' => 'Het contact telefoonnummer is verplicht',
            'contact_number.numeric' => 'Het contact telefoonnummer moet een nummer zijn',
            'contact_number.max' => 'Het contact telefoonnummer mag niet langer zijn dan :max tekens',
        ];
    }
}
