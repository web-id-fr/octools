<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webid\Octools\Models\MemberService;

class MemberServiceResource extends JsonResource
{
    /** @var MemberService $resource */
    public $resource;

    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request)
    {
        return [
            'service' => $this->resource->service,
            'config' => $this->resource->config,
        ];
    }
}
