<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Webid\Octools\Models\Application;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /** @var Application $resource */
    public $resource;

    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'token' => $this->resource->token,
            'workspace' => WorkspaceResource::make($this->whenLoaded('workspace')),
        ];
    }
}
