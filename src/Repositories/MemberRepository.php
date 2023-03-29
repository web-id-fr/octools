<?php

declare(strict_types=1);

namespace Webid\Octools\Repositories;

use Webid\Octools\Models\Member;
use Webid\Octools\Models\Workspace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MemberRepository
{
    public function __construct(private Member $model)
    {
    }

    /**
     * @param Workspace $workspace
     * @return Collection<int,Member>
     */
    public function getAllMembersOfWorkspace(Workspace $workspace): Collection
    {
        return $this->model
            ->with(['workspace', 'services'])
            ->whereRelation('workspace', 'id', $workspace->getKey())
            ->get();
    }

    public function createMember(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function updateMember(array $data, Member $member): bool
    {
        return $member->update($data);
    }

    public function deleteMember(Member $member): bool|null
    {
        return $member->delete();
    }

    public function findByEmail(string $email): Model
    {
        return $this->model->newQuery()
            ->with(['workspace', 'services'])
            ->where('email', $email)
            ->firstOrFail();
    }
}
