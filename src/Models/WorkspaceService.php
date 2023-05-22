<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use App\ApiServices\GitHub\Entities\GithubCredentials;
use App\ApiServices\GitHub\Exceptions\GithubIsNotConfigured;
use App\ApiServices\Gryzzly\Entities\GryzzlyCredentials;
use App\ApiServices\Gryzzly\Exceptions\GryzzlyIsNotConfigured;
use App\ApiServices\Slack\Entities\SlackCredentials;
use App\ApiServices\Slack\Exceptions\SlackIsNotConfigured;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

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

    protected function config(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode(Crypt::decrypt($value)),
            set: fn ($value) => Crypt::encrypt(json_encode($value)),
        );
    }
}
