<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;
use Webid\Octools\Models\Workspace;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'token' => [
                'required',
                'string',
            ],
            'workspace_id' => [
                'required',
                'integer',
                new Exists(Workspace::class, 'id'),
            ],
        ];
    }
}
