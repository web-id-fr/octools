<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'isAdmin' => $this->resource->isAdmin,
            'organization' => OrganizationResource::make($this->whenLoaded('organization')),
        ];
    }
}
