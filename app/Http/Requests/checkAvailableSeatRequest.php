<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class checkAvailableSeatRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'start'          => [
                'required',
                'string',
                Rule::exists('stations', 'name')],
            'end'    => [
                'required',
                'string',
                Rule::exists('stations', 'name'),
            ],
        ];
    }
}
