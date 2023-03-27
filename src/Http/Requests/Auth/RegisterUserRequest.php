<?php

namespace Webid\Octools\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . config('octools.models.user'),
            'password' => ['required', 'confirmed', Password::min(12)
                ->letters()
                ->numbers()
                ->min(12)
                ->symbols()
                ->uncompromised()
            ],
            'organization_name' => 'required|string|max:255|unique:organizations,name',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'email est requise.',
            'email.email' => 'L\'email n\'est pas au bon format (xxx@xxx.xx).',
            'email.unique' => 'L\'email est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'password.min' => 'Le mot de passe doit faire minimum :min charactères.',
            'password.letters' => 'Le mot de passe doit contenir au moins une lettre.',
            'password.numbers' => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols' => 'Le mot de passe doit contenir au moins un symbole.',
            'organization_name.required' => 'Le nom de l\'organisation est requis.',
            'organization_name.unique' => 'Le nom de l\'organisation est déjà utilisé.',
        ];
    }
}
