<?php

namespace Pckg\Htmlbuilder\Event;

use Pckg\Concept\Event\AbstractEvent;
use Pckg\Htmlbuilder\Event\Handler\PrePopulateElement;

/**
 * Class PreDecorationRequested
 *
 * @package Pckg\Htmlbuilder\Event
 */
class PrePopulationRequested extends AbstractEvent
{

    /**
     * @var string
     */
    protected $name = 'htmlbuilder.prepopulate';

    /**
     *
     */
    public function __construct()
    {
        $this->handlers[] = new PrePopulateElement();
    }

}