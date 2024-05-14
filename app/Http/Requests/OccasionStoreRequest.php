<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OccasionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'price' => 'required|numeric',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'power' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
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
            'price.required' => 'De prijs is verplicht.',
            'price.numeric' => 'De prijs moet numeriek zijn.',
            'title.required' => 'De titel is verplicht.',
            'title.max' => 'De titel mag niet langer zijn dan :max tekens.',
            'description.required' => 'De beschrijving is verplicht.',
            'power.required' => 'Het vermogen is verplicht.',
            'power.max' => 'Het vermogen mag niet langer zijn dan :max tekens.',
            'transmission.required' => 'De transmissie is verplicht.',
            'transmission.max' => 'De transmissie mag niet langer zijn dan :max tekens.',
        ];
    }
}
