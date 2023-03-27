<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Organization extends Resource
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
     * @param  \Illuminate\Http\Request  $request
     * @return array<Field>
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Text::make(__('octools::fields.name'), 'name')->sortable(),

            HasMany::make(__('octools::resources.users'), 'users', \App\Nova\User::class),
        ];
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
            return $query->where('id', $user->organization_id);
        }
    }

    public static function label(): string
    {
        return __('octools::resources.organizations');
    }
}
