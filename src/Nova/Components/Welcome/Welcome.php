<?php

namespace Webid\Octools\Nova\Components\Welcome;

use Laravel\Nova\Card;

class Welcome extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'welcome';
    }

    public function meta()
    {
        return [
            'title' => __('octools::resources.welcome_title'),
            'description' => __('octools::resources.welcome_description'),
        ];
    }
}
