<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Webid\Octools\Http\Controllers\Api\ApplicationController;
use Webid\Octools\Http\Controllers\Api\MemberController;
use Webid\Octools\Http\Controllers\Api\OrganizationController;
use Webid\Octools\Http\Controllers\Api\UserController;
use Webid\Octools\Http\Controllers\Api\WorkspaceController;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\Organization;
use Webid\Octools\Models\Workspace;

Route::name('members.')->prefix('members')->group(function () {
    Route::get('{member}', [MemberController::class, 'show'])
        ->where('member', '[0-9]+')
        ->can('showApi,member')
        ->name('show');

    Route::get('/', [MemberController::class, 'index'])
        ->name('index');

    Route::post('/', [MemberController::class, 'store'])
        ->can('storeApi', Member::class)
        ->name('store');

    Route::put('{member}', [MemberController::class, 'update'])
        ->can('updateApi,member')
        ->name('update');

    Route::delete('{member}', [MemberController::class, 'destroy'])
        ->can('deleteApi,member')
        ->name('destroy');

    Route::get('{email}', [MemberController::class, 'showByEmail'])
        ->where('email', '.*')
        ->name('showByEmail');
});

Route::name('workspaces.')->group(function () {
    Route::get('/workspace', [WorkspaceController::class, 'show'])
        ->can('showApi', Workspace::class)
        ->name('show');
});

Route::name('applications.')->group(function () {
    Route::get('/application', [ApplicationController::class, 'show'])
        ->can('showApi', Application::class)
        ->name('show');

    Route::put('/applications/{application}', [ApplicationController::class, 'update'])
        ->can('updateApi,application')
        ->name('update');
});

Route::name('organizations.')->group(function () {
    Route::get('/organization', [OrganizationController::class, 'show'])
        ->can('showApi', Organization::class)
        ->name('show');
});

Route::name('users.')->prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->can('indexApi', User::class)
        ->name('index');

    Route::post('/', [UserController::class, 'store'])
        ->name('store');

    Route::get('{user}', [UserController::class, 'show'])
        ->can('showApi,user')
        ->name('show');
});
