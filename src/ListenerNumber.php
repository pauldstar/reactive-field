<?php

namespace Pauldstar\CalculatedField;

use Pauldstar\CalculatedField\Traits\Listener;
use Laravel\Nova\Fields\Number;

class ListenerNumber extends Number
{
    use Listener;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'listener-number-field';
}
