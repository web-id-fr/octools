<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use Webid\Octools\Nova\Components\WorkspaceServicesFields\WorkspaceServicesFields;

class Workspace extends Resource
{
    public static string $model = '';

    /**
     * @var string
     */
    public static $title = 'name';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'name',
    ];

    /**
     * @var string[]
     */
    public static $with = ['services'];

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $fields = [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('octools::fields.name'), 'name')->sortable(),

            BelongsTo::make(__('octools::resources.organization'), 'organization', Organization::class),

            WorkspaceServicesFields::make(__('octools::resources.services'))->services()->onlyOnForms(),
        ];

        $newFields = [];

        foreach ($this->resource->services() as $service) {
            $newFields[] = Heading::make($service->service)->onlyOnDetail()->hideFromIndex();
            foreach ($service->config as $key => $config) {
                $newFields[] = Text::make($key, function () use ($service, $key) {
                    return $service->config[$key];
                })->onlyOnDetail()->hideFromIndex();
            }
        }

        $fields[] = new Panel('Services', $newFields);
        $fields[] = HasMany::make('Members');
        return $fields;
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(\Laravel\Nova\Http\Requests\NovaRequest $request, $query)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin) {
            return $query;
        } else {
            return $query->where('organization_id', $user->organization_id);
        }
    }

    public static function label(): string
    {
        return __('octools::resources.workspaces');
    }
}
