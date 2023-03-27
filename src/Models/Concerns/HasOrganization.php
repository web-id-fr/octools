<?php

declare(strict_types=1);

namespace Webid\Octools\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOrganization
{
    public function organization(): BelongsTo
    {
        return $this->belongsTo(config('octools.models.organization'));
    }
}
