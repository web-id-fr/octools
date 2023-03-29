<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', Password::defaults()],
            'isAdmin' => ['required', 'boolean'],
            'organization_name' => ['required', 'string', 'unique:organizations,name'],
        ];
    }
}
