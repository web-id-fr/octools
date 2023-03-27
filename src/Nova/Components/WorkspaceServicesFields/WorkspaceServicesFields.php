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
            $data[$service->name] = $resource->{$service->name}?->config;
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
            $configs = Octools::getServiceByKey($serviceName)->connectionConfig;

            foreach ($configs as $config) {
                if (is_null($data[$config]) && !is_null($model->$serviceName)) {
                    $model->$serviceName->delete();
                }
            }

            /** @var class-string<Model> $workspaceServiceModel */
            $workspaceServiceModel = config('octools.models.workspace_service');

            if (is_null($model->$serviceName)) {
                $workspaceServiceModel::query()->insert([
                    'workspace_id' => $model->getKey(),
                    'service' => $serviceName,
                    'config' => json_encode($data),
                ]);
            }

            $workspaceServiceModel::query()
                ->where([['service', $serviceName], ['workspace_id', $model->getKey()]])
                ->update(['config' => json_encode($data)]);

            Event::dispatch("workspace_service_set:{$serviceName}", [
                'member' => $model,
                'data' => $data,
            ]);
        }
    }
}
