<?php

namespace App\Nova;

use App\Product;
use FifteenGroup\NovaReactiveField\ReactiveBelongsTo;
use FifteenGroup\NovaReactiveField\ReactiveCurrency;
use FifteenGroup\NovaReactiveField\ReactiveNumber;
use FifteenGroup\NovaReactiveField\ReactiveSelect;
use FifteenGroup\NovaReactiveField\ReactiveText;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Example extends Resource
{
    public function fields(Request $request)
    {
        return [
            ReactiveBelongsTo::make('Product')->emit('product-input'),

            ReactiveText::make('Product Type')
                ->on('product-input')
                ->handle(function (Collection $col) {
                    return Product::query()->find($col->get('product'))->type->name;
                })
                ->readonly(),

            ReactiveSelect::make('Price Control')
                ->emit('price-modifier')
                ->options([
                    'gross_margin' => 'Gross Margin',
                    'markup' => 'Markup',
                    'base_discount' => 'Base Price Discount',
                    'list_discount' => 'List Price Discount'
                ])
                ->dontFill(),

            ReactiveNumber::make('Target %', 'target')
                ->emit('price-modifier-target')
                ->dontFill(),

            ReactiveCurrency::make('Unit Sell Price')
                ->on(['product-input', 'price-modifier', 'price-modifier-target'])
                ->handle(fn(Collection $col) => 100 * (int) $col->get('target'))
        ];
    }
}
