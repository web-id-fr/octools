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
 * @property Carbon $birthdate
 * @property int $workspace_id
 * @property Model $workspace
 * @property Collection<Model> $services
 * @property ?Model $gryzzly
 * @property ?Model $slack
 */
class Member extends Model
{
    use HasFactory;

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

    public function slack(): HasOne
    {
        return $this->hasOne(config('octools.models.member_service'))->where('service', '=', 'slack');
    }

    public function gryzzly(): HasOne
    {
        return $this->hasOne(config('octools.models.member_service'))->where('service', '=', 'gryzzly');
    }

    public function getGryzzlyUUID(): ?string
    {
        return $this->gryzzly?->config['uuid'] ?? null;
    }

    public function getSlackUsername(): ?string
    {
        return $this->slack?->config['slack_member_id'] ?? null;
    }

    public function fullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeHavingServiceMemberKeyMatching(Builder $builder, string $service, string $memberKey, array $matches): void
    {
        $builder->whereHas('services', fn ($query) => $query
            ->where('service', $service)
            ->whereIn("config->{$memberKey}", $matches)
        );
    }

    public function getServiceMemberIdentity(string $service, string $key): mixed
    {
        return $this->services->firstWhere('service', $service)?->config[$key] ?? null;
    }
}
