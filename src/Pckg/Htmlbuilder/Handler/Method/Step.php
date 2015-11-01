<?php

namespace Pckg\Htmlbuilder\Handler\Method;

use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\Handler\AbstractHandler;
use Pckg\Concept\AbstractObject;

/**
 * Class Step
 * @package Pckg\Htmlbuilder\Handler\Method
 */
class Step extends AbstractHandler
{

    protected $recursive = 1;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['addStep', 'setStepped', 'setStep', 'isStepped', 'isStep'];
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadAddStep(callable $next, AbstractObject $context)
    {
        $form = $context->getElement();

        $step = $form->addFieldset($context->getArg(0));

        //$step->addDecorator($form->decoratorFactory->create('Step'));
        //$step->addHandler($form->handlerFactory->create('Step'));

        $step->setStep();
        $step->setForm($form);

        return $step;
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetStepped(callable $next, AbstractObject $context)
    {
        $form = $context->getElement();

        $form->addDecorator($form->decoratorFactory->create('Step'));

        $form->addClass('stepped');

        return $next();
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetStep(callable $next, AbstractObject $context)
    {
        $fieldset = $context->getElement();

        $fieldset->addClass('step');

        return $next();
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadIsStepped(callable $next, AbstractObject $context)
    {
        $form = $context->getElement();

        return $form->hasClass('stepped');
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadIsStep(callable $next, AbstractObject $context)
    {
        $fieldset = $context->getElement();

        return $fieldset->hasClass('step');
    }

}