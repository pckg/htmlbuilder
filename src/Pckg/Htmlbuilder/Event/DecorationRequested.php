<?php

namespace Pckg\Htmlbuilder\Event;

use Pckg\Concept\Event\AbstractEvent;
use Pckg\Htmlbuilder\Event\Handler\DecorateElement;

/**
 * Class DecorationRequested
 *
 * @package Pckg\Htmlbuilder\Event
 */
class DecorationRequested extends AbstractEvent
{

    /**
     * @var string
     */
    protected $name = 'htmlbuilder.decorate';

    /**
     *
     */
    public function __construct()
    {
        $this->handlers[] = new DecorateElement();
    }
}
