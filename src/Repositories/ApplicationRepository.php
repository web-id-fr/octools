<?php

declare(strict_types=1);

namespace Webid\Octools\Repositories;

use Illuminate\Database\Eloquent\Model;
use Webid\Octools\Models\Application;

class ApplicationRepository
{
    public function __construct(private Application $model)
    {
    }

    public function createApplication(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function updateApplication(array $data, Application $application): bool
    {
        return $application->update($data);
    }
}
