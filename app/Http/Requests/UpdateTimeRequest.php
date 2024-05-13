<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTimeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'days.*.opening_time' => 'nullable|date_format:H:i',
            'days.*.closing_time' => 'nullable|date_format:H:i|after_or_equal:days.*.opening_time',
            'days.*.closed' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'days.*.opening_time.date_format' => 'De openings tijd moet in het formaat uur:minuut zijn.',
            'days.*.closing_time.date_format' => 'De sluitingstijd moet in het formaat uur:minuut zijn.',
            'days.*.closing_time.after_or_equal' => 'De sluitingstijd moet na of gelijk aan de openingstijd liggen.',
            'days.*.closed.boolean' => 'Ongeldige waarde voor gesloten veld.',
        ];
    }
}
