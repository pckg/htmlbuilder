<?php

namespace Pckg\Htmlbuilder\Handler;

use Pckg\Concept\AbstractFactory;
use Pckg\Htmlbuilder\Handler\Method\Basic;
use Pckg\Htmlbuilder\Handler\Method\Query;
use Pckg\Htmlbuilder\Handler\Method\Step;

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
        'Basic' => Basic::class,
        'Query' => Query::class,
        'Step' => Step::class,
    ];

}