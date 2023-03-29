<?php

declare(strict_types=1);

namespace Webid\Octools\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Webid\Octools\Facades\Octools;
use Webid\Octools\Models\Member;
use Webid\Octools\Models\MemberService;

class MemberResource extends JsonResource
{
    /** @var Member $resource */
    public $resource;

    /**
     * @param $request
     * @return array<string,mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'firstname' => $this->resource->firstname,
            'lastname' => $this->resource->lastname,
            'email' => $this->resource->email,
            'birthdate' => $this->resource->birthdate?->format('d-m-Y'),
            'workspace' => WorkspaceResource::make($this->whenLoaded('workspace')),
            'services' => $this->when(
                $this->resource->relationLoaded('services') && $this->resource->relationLoaded('workspace'),
                function () {
                    return $this->resource->services
                        ->keyBy(fn(MemberService $memberService) => $memberService->service)
                        ->map(function (MemberService $memberService) {
                            $octoolsService = Octools::getServiceByKey($memberService->service);

                            return $memberService->config[$octoolsService->memberKey] ?? null;
                        })
                        ->filter()
                        ->toArray();
                }
            ),
        ];
    }
}
