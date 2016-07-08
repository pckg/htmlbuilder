<?php

namespace Pckg\Htmlbuilder\Event\Handler;

use Pckg\Concept\AbstractChainOfReponsibility;
use Pckg\Concept\AbstractObject;

/**
 * Class DecorateElement
 *
 * @package Pckg\Htmlbuilder\Event\Handler
 */
class DecorateElement extends AbstractChainOfReponsibility
{

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function handle(callable $next, AbstractObject $context)
    {
        if ($context->getElement()->hasDecorators()) {
            //$context->getElement()->decorate();
        }
        if ($context->getElement()->hasDecorators() && !isset($context->getElement()->decorated)) {
            $context->getElement()->decorated = true;
            $context->getElement()->decorate();
        }

        return $next();
    }

}