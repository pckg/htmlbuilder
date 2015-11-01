<?php

namespace Pckg\Htmlbuilder\Event;

use Pckg\Htmlbuilder\Event\Handler\PreDecorateElement;
use Pckg\Concept\Event\AbstractEvent;

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