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
            'odometer' => 'required|numeric|max:10',
            'price' => 'required|numeric|max:50',
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'power' => 'required|string|max:50',
            'transmission' => 'required|string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'odometer.max' => 'De kilometerstand mag niet langer zijn dan :max tekens.',
            'price.required' => 'De prijs is verplicht.',
            'price.numeric' => 'De prijs moet numeriek zijn.',
            'price.max' => 'De prijs mag niet langer zijn dan :max tekens.',
            'title.required' => 'De titel is verplicht.',
            'title.max' => 'De titel mag niet langer zijn dan :max tekens.',
            'description.required' => 'De beschrijving is verplicht.',
            'power.required' => 'Het vermogen is verplicht.',
            'power.max' => 'Het vermogen mag niet langer zijn dan :max tekens.',
            'transmission.required' => 'De transmissie is verplicht.',
            'transmission.max' => 'De transmissie mag niet langer zijn dan :max tekens.',
            'images.*.image' => 'De afbeelding moet een afbeelding zijn.',
            'images.*.mimes' => 'De afbeelding moet een jpeg, png of jpg bestand zijn.',
        ];
    }
}
