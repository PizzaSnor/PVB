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
        ];
    }
}
