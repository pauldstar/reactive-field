<?php

namespace Pauldstar\CalculatedField;

use Pauldstar\CalculatedField\Traits\Listener;
use Laravel\Nova\Fields\Text;

class ListenerText extends Text
{
    use Listener;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'listener-text-field';
}
