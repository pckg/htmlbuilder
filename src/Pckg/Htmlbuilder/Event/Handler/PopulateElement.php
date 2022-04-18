<?php

namespace Pckg\Htmlbuilder\Event\Handler;

use Pckg\Concept\AbstractChainOfReponsibility;
use Pckg\Concept\AbstractObject;

/**
 * Class DecorateElement
 *
 * @package Pckg\Htmlbuilder\Event\Handler
 */
class PopulateElement extends AbstractChainOfReponsibility
{
    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function handle(callable $next, AbstractObject $context)
    {
        if ($context->getElement()->hasDecorators() && !isset($context->getElement()->populated)) {
            $context->getElement()->populated = true;
            $context->getElement()->__call('populate', ['context' => $context]);
        }

        return $next();
    }
}
