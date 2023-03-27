<?php

if (!function_exists('loggedApplication')) {
    function loggedApplication(): \Webid\Octools\Models\Application
    {
        if (!auth('api')->check()) {
            throw new \Illuminate\Auth\AuthenticationException();
        }

        /** @var \Webid\Octools\Models\Application $application */
        $application = auth('api')->user();

        return $application;
    }
}
