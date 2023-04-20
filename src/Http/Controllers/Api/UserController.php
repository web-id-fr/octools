<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Webid\Octools\OpenApi\RequestBodies\StoreUserRequestBody;
use Webid\Octools\OpenApi\Responses\ErrorUnauthorizedResponse;
use Webid\Octools\OpenApi\Responses\ListUsersResponse;
use Webid\Octools\OpenApi\Responses\UserResponse;
use Webid\Octools\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Webid\Octools\Http\Requests\Api\StoreUserRequest;
use Webid\Octools\Http\Requests\Api\UpdateUserRequest;
use Webid\Octools\Http\Resources\UserResource;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class UserController
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Get user list.
     */
    #[OpenApi\Operation(tags: ['User'])]
    #[OpenApi\Response(factory: ListUsersResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 403)]
    public function index(): AnonymousResourceCollection
    {
        $users = $this->userRepository->allUsersFromApplication(loggedApplication());
        return UserResource::collection($users);
    }

    /**
     * Create new user.
     */
    #[OpenApi\Operation(tags: ['User'])]
    #[OpenApi\RequestBody(factory: StoreUserRequestBody::class)]
    #[OpenApi\Response(factory: UserResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 403)]
    public function store(StoreUserRequest $request): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->userRepository->createUser($data);

        return response()->json([
            'success' => 'User created with success',
        ], 200);
    }

    /**
     * Get user.
     *
     * @param Authenticatable $user User ID
     */
    #[OpenApi\Operation(tags: ['User'])]
    #[OpenApi\Response(factory: UserResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 403)]
    public function show(Authenticatable $user): UserResource
    {
        return UserResource::make($user->load('organization'));
    }

    /**
     * Update user.
     */
    #[OpenApi\Operation(tags: ['User'])]
    #[OpenApi\Response(factory: UserResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 403)]
    public function update(UpdateUserRequest $request, $user): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->userRepository->updateUser($data, $user);
        return response()->json([
            'success' => 'User updated with success',
        ], 200);
    }

    public function destroy($user): JsonResponse
    {
        $this->userRepository->deleteUser($user);
        return response()->json([
            'success' => 'User deleted with success',
        ], 200);
    }
}
