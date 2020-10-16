<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\Currency;

class ReactiveCurrency extends Currency
{
    use ReactiveField;

    public $component = 'reactive-currency-field';

    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $displayUsing = function ($value) {
            return ! $this->isNullValue($value) ? number_format($value, 2, '.', '') : null;
        };

        $this->currency('GBP')->resolveUsing($displayUsing)->displayUsing($displayUsing);
    }

    public function handle(callable $fn)
    {
        $this->broadcastHandler = function (Collection $col) use ($fn) {
            return $this->format($fn($col));
        };

        return $this;
    }

    public static function format(float $number): string
    {
        return number_format($number, 2, '.', '');
    }
}
