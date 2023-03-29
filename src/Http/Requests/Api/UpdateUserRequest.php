<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Password;
use Webid\Octools\Models\Workspace;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = $this->user;

        return [
            'name' => ['string'],
            'email' => [Rule::unique('users', 'email')->ignore($user->getKey()), 'email'],
            'password' => [Password::defaults()],
            'isAdmin' => ['boolean'],
            'workspace_id' => [
                'integer',
                new Exists(Workspace::class, 'id')
            ],
        ];
    }
}
