<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Controllers\Api;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Webid\Octools\Http\Requests\Api\StoreMemberRequest;
use Webid\Octools\Http\Requests\Api\UpdateMemberRequest;
use Webid\Octools\Http\Resources\MemberResource;
use Webid\Octools\Models\Member;
use Webid\Octools\OpenApi\RequestBodies\StoreMemberRequestBody;
use Webid\Octools\OpenApi\RequestBodies\UpdateMemberRequestBody;
use Webid\Octools\OpenApi\Responses\CreatedResponse;
use Webid\Octools\OpenApi\Responses\DeletedResponse;
use Webid\Octools\OpenApi\Responses\ErrorNotFoundResponse;
use Webid\Octools\OpenApi\Responses\ErrorUnauthenticatedResponse;
use Webid\Octools\OpenApi\Responses\ErrorUnauthorizedResponse;
use Webid\Octools\OpenApi\Responses\ErrorValidationResponse;
use Webid\Octools\OpenApi\Responses\ListMembersResponse;
use Webid\Octools\OpenApi\Responses\MemberResponse;
use Webid\Octools\OpenApi\Responses\UpdatedResponse;
use Webid\Octools\Repositories\MemberRepository;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class MemberController
{
    public function __construct(private MemberRepository $memberRepository)
    {
    }

    /**
     * Get logged application workspace member list.
     *
     * @throws AuthenticationException
     */
    #[OpenApi\Operation(id: 'getMembers', tags: ['Member'])]
    #[OpenApi\Response(factory: ListMembersResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    public function index(): AnonymousResourceCollection
    {
        return MemberResource::collection(
            $this->memberRepository->getAllMembersOfWorkspace(loggedApplication()->workspace)
        );
    }

    /**
     * Create new user.
     */
    #[OpenApi\Operation(id: 'createMember', tags: ['Member'])]
    #[OpenApi\RequestBody(factory: StoreMemberRequestBody::class)]
    #[OpenApi\Response(factory: CreatedResponse::class, statusCode: 201)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    public function store(StoreMemberRequest $request): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->memberRepository->createMember($data);
        return response()->json([
            'success' => 'Member created with success',
        ], 201);
    }

    /**
     * Get member.
     *
     * @param Member $member Member ID
     */
    #[OpenApi\Operation(id: 'getMember', tags: ['Member'])]
    #[OpenApi\Response(factory: MemberResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    public function show(Member $member): MemberResource
    {
        return MemberResource::make($member->load(['workspace', 'services']));
    }

    /**
     * Get member by email.
     *
     * @param string $email Member email
     */
    #[OpenApi\Operation(id: 'getMemberByEmail', tags: ['Member'])]
    #[OpenApi\Response(factory: MemberResponse::class)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    public function showByEmail(string $email): MemberResource
    {
        return MemberResource::make($this->memberRepository->findByEmail($email));
    }

    /**
     * Update member.
     *
     * @param Member $member Member ID
     */
    #[OpenApi\Operation(id: 'updateMember', tags: ['Member'], method: 'PATCH')]
    #[OpenApi\RequestBody(factory: UpdateMemberRequestBody::class)]
    #[OpenApi\Response(factory: UpdatedResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    public function update(UpdateMemberRequest $request, Member $member): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->memberRepository->updateMember($data, $member);
        return response()->json([
            'success' => 'Member updated with success',
        ], 200);
    }

    /**
     * Delete member.
     *
     * @param Member $member Member ID
     */
    #[OpenApi\Operation(id: 'deleteMember', tags: ['Member'])]
    #[OpenApi\Response(factory: DeletedResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorUnauthorizedResponse::class, statusCode: 401)]
    #[OpenApi\Response(factory: ErrorUnauthenticatedResponse::class, statusCode: 403)]
    #[OpenApi\Response(factory: ErrorNotFoundResponse::class, statusCode: 404)]
    public function destroy(Member $member): JsonResponse
    {
        $this->memberRepository->deleteMember($member);
        return response()->json([
            'success' => 'Member deleted with success',
        ], 200);
    }
}
