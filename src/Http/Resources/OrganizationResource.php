<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Webid\Octools\Models\Organization;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /** @var Organization $resource */
    public $resource;

    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'workspaces' => WorkspaceResource::collection($this->whenLoaded('workspaces')),
            'admins' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
