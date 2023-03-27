<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Laravel\Nova\Resource;
use Webid\Octools\Nova\Components\MemberServicesFields\MemberServicesFields;

class Member extends Resource
{
    /**
     * @var string
     */
    public static string $model = '';

    /**
     * @var string
     */
    public static $title = 'firstname';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'firstname', 'lastname', 'email', 'birthdate',
    ];

    /**
     * @var string[]
     */
    public static $with = ['services', 'workspace'];

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $fields = [
            Text::make(__('octools::fields.firstname'), 'firstname')->sortable(),

            Text::make(__('octools::fields.lastname'), 'lastname')->sortable(),

            Text::make(__('octools::fields.email'), 'email')->sortable(),

            Date::make(__('octools::fields.birthdate'), 'birthdate')->sortable(),

            BelongsTo::make(__('octools::resources.workspaces'), 'workspace', Workspace::class),

            MemberServicesFields::make(__('octools::fields.services'))->services()->onlyOnForms(),
        ];

        $resource = $this->resource;

        $newFields = [];

        foreach ($resource->services as $service) {
            $newFields[] = Heading::make($service->service)->onlyOnDetail()->hideFromIndex();
            foreach ($service->config as $key => $config) {
                $newFields[] = Text::make($key, function () use ($service, $key) {
                    return $service->config[$key];
                })->onlyOnDetail()->hideFromIndex();
            }
        }

        $fields[] = new Panel('Services', $newFields);

        return $fields;
    }

    /**
     * Build an "index" query for the given resource.
     *
     * @param NovaRequest $request
     * @param Builder $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin) {
            return $query;
        } else {
            return $query->whereIn('workspace_id', $user->organization->workspaces->pluck('id'));
        }
    }

    public static function label(): string
    {
        return __('octools::resources.members');
    }
}
