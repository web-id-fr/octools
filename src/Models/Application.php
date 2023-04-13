<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;
use Webid\Octools\OctoolsService;

/**
 * @property string $name
 * @property string $token
 * @property int $workspace_id
 * @property Workspace $workspace
 */
class Application extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'token',
        'workspace_id',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.workspace'));
    }

    public function getWorkspaceService(OctoolsService $octoolsService): ?WorkspaceService
    {
        return $this->workspace->services->first(fn (WorkspaceService $service) => $service->service === $octoolsService->name);
    }

    protected function token(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Crypt::decrypt($value) : null,
            set: fn ($value) => Crypt::encrypt($value),
        );
    }
}
