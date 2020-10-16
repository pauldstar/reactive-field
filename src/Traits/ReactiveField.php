<?php

namespace FifteenGroup\NovaReactiveField\Traits;

use Closure;

trait ReactiveField
{
    /**
     * The event this fields broadcasts
     * @var string
     */
    protected $broadcastFrom;

    /**
     * The event this fields handles
     * @var string
     */
    protected $listensTo;

    /**
     * Custom fields with values derived from broadcast input
     * After which these fields will also be broadcast
     *
     * @var Closure
     */
    public $customFields;

    /**
     * The function to call when input is detected
     * @var Closure
     */
    public $broadcastHandler;

    /**
     * Tells the client side component which event to broadcast
     *
     * @param string $event
     * @return $this
     */
    public function emit(string $event)
    {
        $this->broadcastFrom = $event;
        return $this;
    }

    /**
     * The event that the client side component listens to
     *
     * @param string|string[] $event
     * @return $this
     */
    public function on($event)
    {
        $this->listensTo = $event;
        return $this;
    }

    /**
     * A pre-broadcast callback to create new fields with values derived from broadcast input
     *
     * @param string $field
     * @param callable $callback
     * @return $this
     */
    public function customField(string $field, callable $callback)
    {
        $this->customFields || $this->customFields = [];
        $this->customFields[$field] = $callback;
        return $this;
    }

    /**
     * The callback that handles broadcast values
     *
     * @param callable $callback
     * @return $this
     */
    public function handle(callable $callback)
    {
        $this->broadcastHandler = $callback;
        return $this;
    }

    /**
     * Don't fill this attribute on the model when saving
     *
     * @return $this
     */
    public function dontFill()
    {
        $this->fillUsing(fn() => null);
        return $this;
    }

    /**
     * Serialize the field to JSON
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'broadcastFrom' => $this->broadcastFrom,
            'listensTo' => $this->listensTo
        ], parent::jsonSerialize());
    }
}
