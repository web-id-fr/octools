<?php

namespace Webid\Octools\Nova\Components\WorkspaceServicesFields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;
use Webid\Octools\Facades\Octools;

class WorkspaceServicesFields extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'workspace-services-fields';

    /**
     * @return $this
     */
    public function services()
    {
        $finish = [];

        foreach (Octools::getServices() as $service) {
            $finish[$service->name] = $service->connectionConfig;
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
            $serviceConfig = $resource->services->where('service', $service->name)->first()?->config;
            $data[$service->name] = $serviceConfig;
        }

        $this->value = $data;
    }

    /**
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        $model->save();

        $response = json_decode($request[$requestAttribute], true);

        foreach ($response as $serviceName => $data) {
            if (empty(array_filter($data, fn ($value) => $value !== null))) {
                $model->services()->where('service', $serviceName)->delete();
            } else {
                $model->services()->updateOrCreate(
                    [
                        'service' => $serviceName,
                        'workspace_id' => $model->getKey(),
                    ],
                    [
                        'config' => $data,
                    ]
                );
            }

            Event::dispatch("workspace_service_set:{$serviceName}", [
                'member' => $model,
                'data' => $data,
            ]);
        }
    }
}
