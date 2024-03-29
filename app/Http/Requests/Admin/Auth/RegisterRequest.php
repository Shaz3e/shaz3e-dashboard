<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\BaseFormRequest;
use App\Models\Admin;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseFormRequest
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
                'required',
                'email',
                Rule::unique('admins', 'email', Admin::class, ',email'),
            ],
            'password' => [
                'required',
                'min:8',
                'max:255',
                'confirmed',
            ],
        ];
    }
}
