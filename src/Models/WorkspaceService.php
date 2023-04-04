<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $workspace_id
 * @property string $service
 * @property array $config
 * @property Model $workspace
 */
class WorkspaceService extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'workspace_id',
        'service',
        'config',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string>
     */
    protected $casts = [
        'config' => 'array',
    ];

    public function workspace(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.workspace'));
    }

    /**
     * @throws GryzzlyIsNotConfigured
     */
    public function asGryzzlyCredentials(): GryzzlyCredentials
    {
        if (!empty($this->config['token'])) {
            return new GryzzlyCredentials($this->config['token']);
        }
        throw new GryzzlyIsNotConfigured();
    }

    /**
     * @throws SlackIsNotConfigured
     */
    public function asSlackCredentials(): SlackCredentials
    {
        if (!empty($this->config['bot_token'])) {
            return new SlackCredentials($this->config['bot_token']);
        }
        throw new SlackIsNotConfigured();
    }
}
