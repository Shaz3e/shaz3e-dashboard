<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => [
                'string',
                'string',
                'max:255',
            ],
            'email' => [
                'email',
                Rule::unique('users', 'email', User::class, ',email')->ignore($this->user),
            ],
            'password' => [
                'min:8',
                'max:255',
                'confirmed'
            ],
        ];

        if($this->has('name')){
            $rules['name'][] = 'required';
        }

        if($this->has('email')){
            $rules['email'][] = 'required';
        }

        if($this->has('password')){
            $rules['password'][] = 'required';
        }
        
        return $rules;
    }
}
