<?php

declare(strict_types=1);

namespace Webid\Octools\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $member_id
 * @property string $service
 * @property string $identifier
 * @property Member $member
 */
class MemberService extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'member_id',
        'service',
        'identifier',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.member'));
    }
}
