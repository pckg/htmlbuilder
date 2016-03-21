<?php

namespace Pckg\Htmlbuilder\Event;

use Pckg\Concept\Event\AbstractEvent;
use Pckg\Htmlbuilder\Event\Handler\PreDecorateElement;

/**
 * Class PreDecorationRequested
 * @package Pckg\Htmlbuilder\Event
 */
class PreDecorationRequested extends AbstractEvent
{

    /**
     * @var string
     */
    protected $name = 'htmlbuilder.predecorate';

    /**
     *
     */
    public function __construct()
    {
        $this->handlers[] = new PreDecorateElement();
    }

}