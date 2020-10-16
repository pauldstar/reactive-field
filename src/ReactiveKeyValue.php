<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Laravel\Nova\Fields\KeyValue;

class ReactiveKeyValue extends KeyValue
{
    use ReactiveField;

    public $component = 'reactive-key-value-field';

    public function readonly($callback = true)
    {
        return parent::readonly($callback)
            ->disableDeletingRows()
            ->disableAddingRows();
    }

    /**
     * Hide table header
     *
     * @return $this
     */
    public function hideColumnHeaders()
    {
        return $this->withMeta(['hideHeader' => true]);
    }

    /**
     * Add field data
     *
     * @param array $data
     * @return $this
     */
    public function data(array $data)
    {
        return $this->withMeta(['value' => $data]);
    }
}
