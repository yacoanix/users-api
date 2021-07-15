<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                    'name' => 'required|string',
                    'email' => 'required|string|email|unique:users',
                    'password' => 'required|string'
                ];
            case 'PUT':
            case 'PATCH':
                $user_id = $this->route('user')->id;
                return [
                    'name' => 'string',
                    'email' => 'string|email|unique:users,email,'.$user_id,
                    'password' => 'string'
                ];
            default:
                return [];
        }
    }
}
