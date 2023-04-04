<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property int $organization_id
 * @property Model $organization
 * @property Collection<int, Member> $members
 * @property Collection<int, Application> $applications
 * @property Collection<int, WorkspaceService> $services
 */
class Workspace extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.organization'));
    }

    public function members(): HasMany
    {
        return $this->hasMany(config('octools.models.member'));
    }

    public function applications(): HasMany
    {
        return $this->hasMany(config('octools.models.application'));
    }

    public function services(): HasMany
    {
        return $this->hasMany(config('octools.models.workspace_service'));
    }
}
