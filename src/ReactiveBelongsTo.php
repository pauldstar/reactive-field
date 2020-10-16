<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class ReactiveBelongsTo extends BelongsTo
{
    use ReactiveField;

    public $component = 'reactive-belongs-to-field';

    /**
     * The input field whose value this field depends on
     * Could be set to custom field
     */
    public string $dependsOn = '';

    /**
     * If the relation between this field and the input field is BelongsToMany
     * and NOT the default BelongsTo
     */
    private ?string $belongsToMany;

    /**
     * The field name in database table representing $dependsOn
     */
    public string $dependsOnKey;

    public function __construct($name, $attribute = null, $resource = null)
    {
        parent::__construct($name, $attribute, $resource);
        $this->handle(false);
    }

    /**
     * Set the depends on field and depends on key
     * Used to filter resources to be displayed
     *
     * @param string $formField input field used to filter select options
     * @param string|null $key database column or relation name representing $dependsOn field
     * @param string|null $belongsToMany the relation name if the relationship to $formField is BelongsToMany
     * @return $this
     */
    public function dependsOn(string $formField, string $key = null, string $belongsToMany = null)
    {
        $this->dependsOn = $formField;

        $this->dependsOnKey = $key
            ?? ($belongsToMany ? "{$belongsToMany}_id" : "{$formField}_id");

        $this->belongsToMany = $belongsToMany;

        return $this;
    }

    /**
     * The callback for setting a default selected option when input is detected
     *
     * @param callable|bool $initialSelectFunction To select default option
     * Set true to select first option by default
     * Set false to select nothing
     *
     * @param callable|null $handler to calculate resources to load
     *
     * @return $this
     */
    public function handle($initialSelectFunction, callable $handler = null)
    {
        if (!$handler) {
            $this->broadcastHandler =
                function (Collection $values, NovaRequest $request) use ($initialSelectFunction) {
                    return [
                        'dependsOnId' => $values->get($this->dependsOn),
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
     * @param NovaRequest $request
     * @param bool $withTrashed
     * @return Builder
     */
    public function buildAssociatableQuery(NovaRequest $request, $withTrashed = false)
    {
        $query = parent::buildAssociatableQuery($request, $withTrashed);

        if ($request->missing('dependsOnValue')) {
            return $query;
        }

        if ($this->belongsToMany) {
            return $query->whereHas($this->belongsToMany,
                function (Builder $query) use ($request) {
                    $query->where($this->dependsOnKey, $request->dependsOnValue);
                }
            );
        }

        return $query->where($this->dependsOnKey, $request->dependsOnValue);
    }
}
