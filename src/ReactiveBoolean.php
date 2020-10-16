<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Laravel\Nova\Fields\Boolean;

class ReactiveBoolean extends Boolean
{
    use ReactiveField;

    public $component = 'reactive-boolean-field';
}
