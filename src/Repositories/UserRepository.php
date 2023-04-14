<?php

declare(strict_types=1);

namespace Webid\Octools\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Webid\Octools\Models\Application;
use Webid\Octools\Models\Organization;

class UserRepository
{
    private Model $model;
    public function __construct()
    {
        $this->model = new (config('octools.models.user'));
    }

    /**
     * @param Application $application
     * @return Collection<int,User>
     */
    public function allUsersFromApplication(Application $application): Collection
    {
        return $application->workspace->organization->users->load(['organization']);
    }

    public function createUser(array $data): Model
    {
        $organization = Organization::create([
            'name' => $data['organization_name'],
        ]);

        $data['organization_id'] = $organization->getKey();

        return $this->model->newQuery()->create($data);
    }

    public function updateUser(array $data, User $user): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $user->update($data);
    }

    public function deleteUser(User $user): bool|null
    {
        return $user->delete();
    }
}
