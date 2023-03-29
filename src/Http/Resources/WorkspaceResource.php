<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webid\Octools\Models\Workspace;

class WorkspaceResource extends JsonResource
{
    /** @var Workspace $resource */
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
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
            'services' => WorkspaceServiceResource::collection($this->whenLoaded('services')),
            'members' => MemberResource::collection($this->whenLoaded('members')),
        ];
    }
}
