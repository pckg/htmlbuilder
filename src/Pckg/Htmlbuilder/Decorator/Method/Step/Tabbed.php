<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Step;

use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element\Fieldset;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\ElementObject;

class Tabbed extends AbstractDecorator
{

    public $heading;
    public $title;

    public function overloadPreDecorate(ElementObject $context)
    {
        $element = $context->getElement();

        if ($element instanceof Fieldset && $element->isStep()) {
            $this->decorateHeading($element);

        } else if ($element instanceof Form) {
            $this->mergeFormSteps($element);

        }
    }

    public function overloadDecorate(ElementObject $context)
    {
        $this->decorateTitle($context->getElement());
    }

    /**
     * @param $fieldset
     */
    protected function decorateTitle($fieldset)
    {
        if ($this->title) {
            $title = $fieldset->elementFactory->create('Div');
            $title->addChild($this->title)->addClass('legend');
            $fieldset->prependChild($title);

        }
    }

    /**
     * @param $fieldset
     */
    protected function decorateHeading($fieldset)
    {
        $fieldset->setTag('div akaFieldset');

        if ($this->heading) {
            $form = $fieldset->getForm();
            $heading = $fieldset->elementFactory->createFromExpression('li')->setAttribute('data-toggle', 'tab');
            $heading->addHandler($fieldset->handlerFactory->create('Query'));

            $navigatorHolder = $fieldset->getForm()->findChild('.nav nav-tabs');

            if (!$navigatorHolder || $navigatorHolder === $fieldset->getForm()) {
                $navigatorHolder = $form->elementFactory->createFromExpression('ul.nav nav-tabs');
                $form->prependChild($navigatorHolder);
            }

            $navigatorHolder->addChild($heading);

            $index = $heading->getIndex();
            $heading->addChild('<a href="#' . $fieldset->getForm()->getId() . 'Step' . $heading->getIndex() . '" data-toggle="tab">' . $this->heading . '</a>');

            if ($index == 0) {
                $heading->addClass('active');
            }
        }
    }

    /**
     * @param $form
     */
    protected function mergeFormSteps($form)
    {
        $form->setTag('div')->addClass('formGroup');

        $arrChildrenSteps = $form->removeChildren('*');

        $pane = $form->elementFactory->create('Div')->addClass('tab-content');

        foreach ($arrChildrenSteps AS $i => $step) {
            $pane->addChild($step);
            $step->setId($form->getId() . 'Step' . $i);

            if ($i == 0) {
                $step->addClass('active');
            }

            //$step->setId($step->getForm()->getId() . 'Step' . $i);

            $step->addClass('tab-pane');
        }

        $form->addChild($pane);
    }

}