<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users','email'),
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
