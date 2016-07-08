<?php

namespace Pckg\Htmlbuilder\Event\Handler;

use Pckg\Concept\AbstractChainOfReponsibility;
use Pckg\Concept\AbstractObject;

/**
 * Class PreDecorateElement
 *
 * @package Pckg\Htmlbuilder\Event\Handler
 */
class PrePopulateElement extends AbstractChainOfReponsibility
{

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function handle(callable $next, AbstractObject $context)
    {
        if ($context->getElement()->hasDecorators() && !isset($context->getElement()->prepopulate)) {
            $context->getElement()->prepopulate = true;
            $context->getElement()->prePopulate();
        }

        return $next();
    }

}