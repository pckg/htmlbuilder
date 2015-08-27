<?php

namespace Pckg\Htmlbuilder\Handler;

use Pckg\Concept\AbstractFactory;

/**
 * Class HandlerFactory
 * @package Pckg\Htmlbuilder\Handler
 */
class HandlerFactory extends AbstractFactory
{

    /**
     * @var array
     */
    protected $mapper = [
        'Basic' => '\Pckg\Htmlbuilder\Handler\Method\Basic',
        'Query' => '\Pckg\Htmlbuilder\Handler\Method\Query',
        'Step' => '\Pckg\Htmlbuilder\Handler\Method\Step',
    ];

}