<?php

namespace Fusion\CalculatedField;

use Fusion\CalculatedField\Traits\Broadcaster;
use Laravel\Nova\Fields\BelongsTo;

class BroadcasterBelongsTo extends BelongsTo
{
    use Broadcaster;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'broadcaster-belongs-to-field';
}
