<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Webid\Octools\OctoolsService;

/**
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property Carbon|null $birthdate
 * @property int $workspace_id
 * @property Model $workspace
 * @property Collection<int, MemberService> $services
 */
class Member extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'birthdate',
        'workspace_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'birthdate' => 'date',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.workspace'));
    }

    public function services(): HasMany
    {
        return $this->hasMany(config('octools.models.member_service'));
    }

    public function fullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeHavingServiceMemberKeyMatching(Builder $builder, OctoolsService $service, array $matches): void
    {
        $builder->whereHas(
            'services',
            fn ($query) => $query
            ->where('service', $service->name)
            ->whereIn('identifier', $matches)
        );
    }

    public function getUsernameForService(OctoolsService $service): mixed
    {
        return $this->services->firstWhere('service', $service->name)?->identifier ?? null;
    }
}
