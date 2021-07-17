<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'    => 'required|string',
                    'surname' => 'required|string',
                    'photo'   => [
                        'image',
                        Rule::dimensions()->maxWidth(500)->maxHeight(500)
                    ],
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name'    => 'string',
                    'surname' => 'string',
                    'photo'   => [
                        'image',
                        Rule::dimensions()->maxWidth(500)->maxHeight(500)
                    ],
                ];
            default:
                return [];
        }
    }
}
