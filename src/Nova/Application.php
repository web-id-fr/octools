<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Resource;

class Application extends Resource
{
    /**
     * @var string
     */
    public static string $model = '';

    /**
     * @var string
     */
    public static $title = 'id';

    /**
     * @var string[]
     */
    public static $search = [
        'id',
    ];

    /**
     * @var string[]
     */
    public static $with = ['workspace', 'workspace.services'];

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Field>
     */
    public function fields(Request $request)
    {
        $token = Str::random(128);

        return [
            BelongsTo::make(__('octools::resources.workspaces'), 'workspace', Workspace::class),

            Text::make(__('octools::fields.name'), 'name'),

            Text::make(__('Token'), 'token')
                ->default(fn () => $token)
                ->hideWhenUpdating(),
        ];
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
            return $query->whereIn('workspace_id', $user->organization->workspaces->pluck('id'));
        }
    }

    public static function label(): string
    {
        return __('octools::resources.applications');
    }
}
