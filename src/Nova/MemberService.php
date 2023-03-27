<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Card;
use Laravel\Nova\Contracts\Filter;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Resource;

class MemberService extends Resource
{
    /** @var bool $displayInNavigation */
    public static $displayInNavigation = false;

    public $resource;

    public static string $model = '';

    /**
     * @var string
     */
    public static $title = 'service';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'service' ,'config',
    ];

    public function title(): string
    {
        return $this->resource->service->value;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Field>
     */
    public function fields(Request $request)
    {
        return [];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Card>
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Filter>
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Lens>
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<Action>
     */
    public function actions(Request $request)
    {
        return [];
    }
}
