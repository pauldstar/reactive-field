<?php

namespace Fusion\CalculatedField;

use Fusion\CalculatedField\Traits\Listener;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class ListenerBelongsTo extends BelongsTo
{
    use Listener;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'listener-belongs-to-field';

    private $dependsOnField;

    /***
     * ListenerField constructor.
     * @param $name
     * @param null $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->listensTo = 'broadcast-field-input';
        $this->set(false);
    }

    /**
     * Set the depends on field and depends on key
     *
     * @param string $dependsOnField input field used to filter select options
     * @param string $tableKey foreign key name in database table representing $dependsOnField
     * @return $this
     */
    public function dependsOn(string $dependsOnField, string $tableKey = null)
    {
        $tableKey || $tableKey = $dependsOnField . '_id';

        $this->dependsOnField = $dependsOnField;

        return $this->withMeta([
            'dependsOn' => $dependsOnField,
            'dependsOnKey' => $tableKey,
        ]);
    }

    /**
     * The callback we want to call when the field has some input
     *
     * @param callable|bool $initialSelectFunction To select default option
     * Set true to select first option by default
     * Set false to select nothing
     *
     * @param callable $calculateFunction to calculate resources to load
     *
     * @return $this
     */
    public function set($initialSelectFunction, callable $calculateFunction = null)
    {
        if (!$calculateFunction) {
            $this->calculateFunction =
                function (Collection $values, NovaRequest $request) use ($initialSelectFunction) {
                    return [
                        'dependsOnId' => $values->get($this->dependsOnField),
                        'initialSelectId' => is_callable($initialSelectFunction)
                            ? $initialSelectFunction($values, $request)
                            : $initialSelectFunction
                    ];
                };
        }

        return $this;
    }

    /**
     * Build an associatable query for the field.
     * Here is where we add the depends on value and filter results
     *
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param bool $withTrashed
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function buildAssociatableQuery(NovaRequest $request, $withTrashed = false)
    {
        $query = parent::buildAssociatableQuery($request, $withTrashed);

        if ($request->has('dependsOnValue')) {
            $query->where($this->meta['dependsOnKey'], $request->dependsOnValue);
        }

        return $query;
    }
}
