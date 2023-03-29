<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Requests\Api;

use Webid\Octools\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class StoreMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'unique:members', 'email'],
            'birthdate' => ['required', 'date'],
            'workspace_id' => [
                'required',
                'integer',
                new Exists(Workspace::class, 'id')
            ],
        ];
    }
}
