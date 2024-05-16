<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainInfoUpdateRequest extends FormRequest
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
            'main_content' => 'required',
            'max_cars_per_day' => 'required|numeric|max:10|min:1',
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
            'main_content.required' => 'Algemene informatie is verplicht.',
            'max_cars_per_day.required' => 'Het maximale aantal auto\'s per dag is verplicht.',
            'max_cars_per_day.numeric' => 'Het maximale aantal auto\'s per dag moet numeriek zijn.',
            'max_cars_per_day.max' => 'Het maximale aantal auto\'s per dag mag niet langer zijn dan :max tekens.',
            'max_cars_per_day.min' => 'Het maximale aantal auto\'s per dag moet minimaal :min tekens zijn.',
        ];
    }
}
