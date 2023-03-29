<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\Workspace;

class UpdateMemberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var Member $member */
        $member = $this->member;

        return [
            'firstname' => ['string'],
            'lastname' => ['string'],
            'email' => [Rule::unique('members')->ignore($member->getKey()), 'email'],
            'birthdate' => ['date'],
            'workspace_id' => [
                'integer',
                new Exists(Workspace::class, 'id')
            ],
        ];
    }
}
