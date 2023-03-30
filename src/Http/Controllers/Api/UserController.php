<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use App\Models\User;
use Webid\Octools\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Webid\Octools\Http\Requests\Api\StoreUserRequest;
use Webid\Octools\Http\Requests\Api\UpdateUserRequest;
use Webid\Octools\Http\Resources\UserResource;

class UserController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $users = $this->userRepository->allUsersFromApplication(loggedApplication());
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->userRepository->createUser($data);

        return response()->json([
            'success' => 'User created with success',
        ], 200);
    }

    public function show(User $user): UserResource
    {
        return UserResource::make($user->load('organization'));
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->userRepository->updateUser($data, $user);
        return response()->json([
            'success' => 'User updated with success',
        ], 200);
    }

    public function destroy(User $user): JsonResponse
    {
        $this->userRepository->deleteUser($user);
        return response()->json([
            'success' => 'User deleted with success',
        ], 200);
    }
}
