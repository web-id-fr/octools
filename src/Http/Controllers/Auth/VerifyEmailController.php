<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(config('octools.routing.login_redirect') . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            /** @phpstan-ignore-next-line */
            event(new Verified($request->user()));
        }

        return redirect()->intended(config('octools.routing.login_redirect') . '?verified=1');
    }
}
