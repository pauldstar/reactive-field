<?php

namespace FifteenGroup\NovaReactiveField;

use FifteenGroup\NovaReactiveField\Traits\ReactiveField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Contracts\RelatableField;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ResourceRelationshipGuesser;

class ReactiveHasMany extends Field implements RelatableField
{
    use ReactiveField { jsonSerialize as reactiveFieldJsonSerialize; }

    public $component = 'reactive-has-many-field';

    /**
     * The class name of the related resource.
     *
     * @var string
     */
    public $resourceClass;

    /**
     * The URI key of the related resource.
     *
     * @var string
     */
    public $resourceName;

    /**
     * The name of the Eloquent "has many" relationship.
     *
     * @var string
     */
    public $hasManyRelationship;

    /**
     * The name of the inverse Eloquent "belongs to" relationship.
     *
     * @var string
     */
    public $belongsToRelationship;

    /**
     * The displayable singular label of the relation.
     *
     * @var string
     */
    public $singularLabel;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string $belongsTo name of the inverse Eloquent "belongs to" relationship
     * @param string|null $hasMany name of the Eloquent "has many" relationship.
     * @param string|null $resource
     */
    public function __construct($name, string $belongsTo, $hasMany = null, $resource = null)
    {
        parent::__construct($name, $hasMany);

        $resource = $resource ?? ResourceRelationshipGuesser::guessResource($name);

        $this->resourceClass = $resource;
        $this->resourceName = $resource::uriKey();
        $this->belongsToRelationship = $belongsTo;
        $this->hasManyRelationship = $this->attribute;
        $this->hideFromIndex();
    }

    /**
     * Show tabbed groups on the resource table
     * Resource model must be related to App\TableGroup
     *
     * @return ReactiveHasMany
     */
    public function showTableGroups()
    {
        return $this->withMeta(['showTableGroups' => true]);
    }

    /**
     * Group row items with notes on the resource table
     * Resource model must be related to App\TableNote
     *
     * @return ReactiveHasMany
     */
    public function notable()
    {
        return $this->withMeta(['notable' => true]);
    }

    /**
     * Drag and sort row items
     *
     * @return ReactiveHasMany
     */
    public function draggable()
    {
        return $this->withMeta(['draggable' => true]);
    }

    /**
     * Determine if the field should be displayed for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        return call_user_func(
            [$this->resourceClass, 'authorizedToViewAny'], $request
        ) && parent::authorize($request);
    }

    /**
     * Set the displayable singular label of the resource.
     *
     * @return $this
     */
    public function singularLabel($singularLabel)
    {
        $this->singularLabel = $singularLabel;

        return $this;
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'hasManyRelationship' => $this->hasManyRelationship,
            'belongsToRelationship' => $this->belongsToRelationship,
            'tabulated' => true,
            'perPage'=> $this->resourceClass::$perPageViaRelationship,
            'resourceName' => $this->resourceName,
            'singularLabel' => $this->singularLabel ?? Str::singular($this->name),
        ], $this->reactiveFieldJsonSerialize());
    }
}
