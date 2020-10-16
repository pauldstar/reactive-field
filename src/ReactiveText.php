<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Laravel\Nova\Fields\Text;

class ReactiveText extends Text
{
    use ReactiveField;

    public $component = 'reactive-text-field';
}
