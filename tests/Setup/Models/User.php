<?php

declare(strict_types=1);

namespace Tests\Setup\Models;

use Illuminate\Database\Eloquent\Model;
use Webid\Octools\Models\Concerns\HasOrganization;
use Webid\Octools\Models\Workspace;


/**
 * @property string $name
 * @property string $token
 * @property int $workspace_id
 * @property Workspace $workspace
 */
class User extends Model
{
    use HasOrganization;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id',
        'isAdmin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isAdmin' => 'boolean',
    ];
}
