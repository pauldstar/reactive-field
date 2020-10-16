<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Laravel\Nova\Fields\Number;

class ReactiveNumber extends Number
{
    use ReactiveField;

    public $component = 'reactive-number-field';
}
