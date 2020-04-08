<?php

namespace Fusion\CalculatedField;

use Fusion\CalculatedField\Traits\Broadcaster;
use Laravel\Nova\Fields\Number;

class BroadcasterNumber extends Number
{
    use Broadcaster;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'broadcaster-number-field';
}
