<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        $user = $request->user();

        return $user->hasVerifiedEmail()
                    ? redirect()->intended(config('octools.routing.login_redirect'))
                    : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
