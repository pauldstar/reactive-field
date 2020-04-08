<?php

namespace Fusion\CalculatedField;

use Fusion\CalculatedField\Traits\Broadcaster;
use Laravel\Nova\Fields\Boolean;

class BroadcasterBoolean extends Boolean
{
    use Broadcaster;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'broadcaster-boolean-field';
}
