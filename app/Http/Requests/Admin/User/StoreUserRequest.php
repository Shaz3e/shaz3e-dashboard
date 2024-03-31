<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class StoreUserRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'string',
                'max:255',
            ],
            'email' => [
                'email',
                Rule::unique('users', 'email', '', User::class, ',email'),
            ],
            'password' => [
                'required',
                'min:8',
                'max:255',
                'confirmed'
            ],
        ];
    }
}
