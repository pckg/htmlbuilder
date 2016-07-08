<?php

namespace Pckg\Htmlbuilder\Event;

use Pckg\Concept\Event\AbstractEvent;
use Pckg\Htmlbuilder\Event\Handler\PopulateElement;

/**
 * Class DecorationRequested
 *
 * @package Pckg\Htmlbuilder\Event
 */
class PopulationRequested extends AbstractEvent
{

    /**
     * @var string
     */
    protected $name = 'htmlbuilder.populate';

    /**
     *
     */
    public function __construct()
    {
        $this->handlers[] = new PopulateElement();
    }

}