<?php

namespace Pauldstar\CalculatedField\Traits;

use Closure;

trait Listener
{
    /**
     * The event this fields listens for
     * @var string
     */
    protected $listensTo;

    /**
     * The function to call when input is detected
     * @var Closure
     */
    public $calculateFunction;

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
    }

    /**
     * The channel that the client side component listens to
     * @param $channel
     * @return $this
     */
    public function listensTo($channel)
    {
        $this->listensTo = $channel;
        return $this;
    }

    /***
     * The callback we want to call when the field has some input
     *
     * @param callable $calculateFunction
     * @return $this
     */
    public function set(callable $calculateFunction)
    {
        $this->calculateFunction = $calculateFunction;
        return $this;
    }

    /***
     * Serialize the field to JSON
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge([
            'listensTo' => $this->listensTo
        ], parent::jsonSerialize());
    }
}
