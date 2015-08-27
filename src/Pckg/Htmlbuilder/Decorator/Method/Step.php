<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Htmlbuilder\Decorator;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;
use Pckg\Concept\AbstractObject;

/**
 * Class Step
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
        $this->stepStrategy = clone $this->stepStrategy;
    }

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['useStepStrategy', 'getStepStrategy', 'preDecorate', 'decorate', 'setTitle', 'setHeading'];
    }

    public function overloadUseStepStrategy(AbstractObject $context)
    {
        $this->stepStrategy = is_object($context->getArg(0))
            ? $context->getArg(0)
            : $context->getElement()->decoratorFactory->create($context->getArg(0));

        return $this->next->overloadUseStepStrategy($context);
    }

    public function overloadGetStepStrategy(AbstractObject $context)
    {
        $context->setReturn('result');

        return $this->stepStrategy;
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetTitle(AbstractObject $context)
    {
        $this->title = $context->getArg(0);

        return $this->next->overloadSetTitle($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetHeading(AbstractObject $context)
    {
        $this->heading = $context->getArg(0);

        return $this->next->overloadSetHeading($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadPreDecorate(AbstractObject $context)
    {
        $element = $context->getElement();

        if ($element->isStepped() || $element->isStep()) {
            $this->stepStrategy->heading = $this->heading;
            $this->stepStrategy->title = $this->title;

            $this->stepStrategy->overloadPreDecorate($context);
        }

        return $this->next->overloadPreDecorate($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadDecorate(AbstractObject $context)
    {
        $element = $context->getElement();

        if ($element->isStepped() || $element->isStep()) {
            $this->stepStrategy->overloadDecorate($context);
        }

        return $this->next->overloadDecorate($context);
    }
}