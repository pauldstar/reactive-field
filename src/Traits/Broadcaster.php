<?php

namespace Pauldstar\CalculatedField\Traits;

use Laravel\Nova\Element;

trait Broadcaster
{
    /**
     * BroadcasterField constructor.
     *
     * @param $name
     * @param null $attribute
     * @param callable|null $resolveCallback
     */
    public function __construct($name, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->broadcastTo('broadcast-field-input');
    }

    /**
     * Tells the client side component which channel to broadcast on
     * @param $broadcastChannel
     * @return Element
     */
    public function broadcastTo($broadcastChannel):Element
    {
        return $this->withMeta([
            'broadcastTo' => $broadcastChannel
        ]);
    }
}
