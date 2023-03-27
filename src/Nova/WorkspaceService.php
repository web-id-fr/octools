<?php

declare(strict_types=1);

namespace Webid\Octools\Nova;

use Webid\Octools\Models\WorkspaceService as WorkspaceServiceModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Resource;

class WorkspaceService extends Resource
{
    /** @var bool $displayInNavigation */
    public static $displayInNavigation = false;

    /** @var WorkspaceServiceModel */
    public $resource;

    public static string $model = WorkspaceServiceModel::class;

    /**
     * @var string
     */
    public static $title = 'service';

    /**
     * @var string[]
     */
    public static $search = [
        'id', 'service', 'config',
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
}
