<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Webid\Octools\Http\Requests\Auth\RegisterUserRequest;

class RegisteredUserController
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $request->validated();

        $organization = config('octools.models.organization')::create([
            'name' => $request->organization_name,
        ]);

        /** @var string $password */
        $password = $request->password;

        $user = config('octools.models.user')::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'organization_id' => $organization->getKey(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(config('octools.routing.login_redirect'));
    }
}
