<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'licence_plate' => 'required|string|max:50',
            'odometer' => 'required|numeric',
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
            'licence_plate.required' => 'Het kenteken is verplicht.',
            'licence_plate.max' => 'Het kenteken mag niet langer zijn dan :max tekens.',
            'odometer.required' => 'De kilometerstand is verplicht.',
            'odometer.numeric' => 'De kilometerstand moet numeriek zijn.',
        ];
    }
}
