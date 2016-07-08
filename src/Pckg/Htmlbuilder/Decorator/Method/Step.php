<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;

/**
 * Class Step
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Step extends AbstractDecorator
{

    use Decorator\Strategy;

    protected $recursive = true;

    protected $stepStrategy = 'Step\Tabbed'; // tabbed, horizontal/accordion

    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $heading;

    /**
     *
     */
    public function __clone()
    {
        //$this->stepStrategy = clone $this->stepStrategy;
    }

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['useStepStrategy', 'getStepStrategy', 'preDecorate', 'decorate', 'setTitle', 'setHeading'];
    }

    public function overloadUseStepStrategy(callable $next, AbstractObject $context)
    {
        $this->stepStrategy = is_object($context->getArg(0))
            ? $context->getArg(0)
            : $context->getElement()->decoratorFactory->create($context->getArg(0));

        return $next();
    }

    public function overloadGetStepStrategy(callable $next, AbstractObject $context)
    {
        $context->setReturn('result');

        return $this->stepStrategy;
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetTitle(callable $next, AbstractObject $context)
    {
        $this->title = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetHeading(callable $next, AbstractObject $context)
    {
        $this->heading = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadPreDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if ($element->isStepped() || $element->isStep()) {
            $this->stepStrategy->heading = $this->heading;
            $this->stepStrategy->title = $this->title;

            $this->stepStrategy->overloadPreDecorate($next, $context);
        }

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if ($element->isStepped() || $element->isStep()) {
            $this->stepStrategy->overloadDecorate($next, $context);
        }

        return $next();
    }
}