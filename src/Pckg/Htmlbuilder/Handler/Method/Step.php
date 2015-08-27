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
    public function overloadAddStep(AbstractObject $context)
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
    public function overloadSetStepped(AbstractObject $context)
    {
        $form = $context->getElement();

        $form->addDecorator($form->decoratorFactory->create('Step'));

        $form->addClass('stepped');

        return $this->next->overloadSetStepped($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetStep(AbstractObject $context)
    {
        $fieldset = $context->getElement();

        $fieldset->addClass('step');

        return $this->next->overloadSetStep($context);
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadIsStepped(AbstractObject $context)
    {
        $form = $context->getElement();

        return $form->hasClass('stepped');
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadIsStep(AbstractObject $context)
    {
        $fieldset = $context->getElement();

        return $fieldset->hasClass('step');
    }

}