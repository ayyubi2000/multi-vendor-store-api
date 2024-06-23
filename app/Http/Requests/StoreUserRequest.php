<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
//        return Auth::check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required','min:6'],
            'museum_id' => ['nullable','numeric'],
            'roles' => ['array', 'required'],
            'roles.*.role_code' => ['required', 'string'],
            'roles.*.status' => ['required', 'boolean']
        ];
    }
}
