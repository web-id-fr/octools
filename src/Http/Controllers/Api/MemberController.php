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
use Webid\Octools\Repositories\MemberRepository;

class MemberController
{
    public function __construct(private MemberRepository $memberRepository)
    {
    }

    /**
     * @throws AuthenticationException
     */
    public function index(): AnonymousResourceCollection
    {
        return MemberResource::collection(
            $this->memberRepository->getAllMembersOfWorkspace(loggedApplication()->workspace)
        );
    }

    public function store(StoreMemberRequest $request): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->memberRepository->createMember($data);
        return response()->json([
            'success' => 'Member created with success',
        ], 200);
    }

    public function show(Member $member): MemberResource
    {
        return MemberResource::make($member->load(['workspace', 'services']));
    }

    public function showByEmail(string $email): MemberResource
    {
        return MemberResource::make($this->memberRepository->findByEmail($email));
    }

    public function update(UpdateMemberRequest $request, Member $member): JsonResponse
    {
        /** @var array $data */
        $data = $request->validated();

        $this->memberRepository->updateMember($data, $member);
        return response()->json([
            'success' => 'Member updated with success',
        ], 200);
    }

    public function destroy(Member $member): JsonResponse
    {
        $this->memberRepository->deleteMember($member);
        return response()->json([
            'success' => 'Member deleted with success',
        ], 200);
    }
}
