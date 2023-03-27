<?php

declare(strict_types=1);

namespace Webid\Octools\Nova\Components\MemberServicesFields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\Octools\Facades\Octools;

class MemberServicesFields extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'member-services-fields';

    /**
     * @return $this
     */
    public function services()
    {
        $finish = [];

        foreach (Octools::getServices() as $service) {
            $finish[$service->name] = [$service->memberKey];
        }

        return $this->withMeta(['services' => $finish]);
    }

    /**
     * @param mixed $resource
     * @param null  $attribute
     */
    public function resolve($resource, $attribute = null): void
    {
        $data = [];

        foreach (Octools::getServices() as $service) {
            $data[$service->name] = $resource->{$service->name}?->config;
        }

        $this->value = $data;
    }

    /**
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  Model  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        $model->save();

        if ($model->workspace_id !== intval($request->get('workspace'))) {
            return;
        }

        $response = json_decode($request[$requestAttribute], true);


        foreach ($response as $serviceName => $data) {
            $configKey = Octools::getServiceByKey($serviceName)->memberKey;

            $data = Arr::only($data, $configKey);
            if (empty($data[$configKey] ?? null)) {
                $data = [];
            }

            /** @var class-string<Model> $memberServiceModel */
            $memberServiceModel = config('octools.models.member_service');

            $memberServiceModel::query()
                ->when(
                    !empty($data),
                    fn ($query) => $query->updateOrCreate(
                        [
                            'member_id' => $model->getKey(),
                            'service' => $serviceName,
                        ],
                        [
                            'config' => $data,
                        ]
                    ),
                    fn ($query) => $query->where(
                        [
                            'member_id' => $model->getKey(),
                            'service' => $serviceName,
                        ]
                    )->delete(),
                );

            Event::dispatch("member_service_set:{$serviceName}", [
                'member' => $model,
                'data' => $data,
            ]);
        }
    }
}
