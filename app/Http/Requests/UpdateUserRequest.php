<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['nullable','string'],
            'email' => ['nullable','email'],
            'password' => ['nullable','min:6'],
            'museum_id' => ['nullable','numeric'],
            'roles' => ['array', 'nullable'],
            'roles.*.role_code' => ['nullable', 'string'],
            'roles.*.status' => ['nullable', 'boolean']
        ];
    }
}
