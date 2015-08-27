<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Step;

use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element\Fieldset;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\ElementObject;

class Horizontal extends AbstractDecorator
{

    public $heading;
    public $title;

    public function overloadPreDecorate(ElementObject $context)
    {

    }

    public function overloadDecorate(ElementObject $context)
    {
        $element = $context->getElement();

        if ($element instanceof Fieldset) {
            if ($element->isStep()) {
                $this->decorateStepFieldset($element);
            }

        } else if ($element instanceof Form) {
            if ($element->isStepped()) {
                $element->setTag('div')->addClass('formGroup panel-group')->setAttribute('role', 'tablist')->setAttribute('aria-multiselectable', 'true');

            }

        }
    }

    protected function decorateStepFieldset($fieldset)
    {
        $this->decorateHeading($fieldset);
        $this->decorateTitle($fieldset);
    }

    /**
     * @param $fieldset
     */
    protected function decorateTitle($fieldset)
    {
        if ($this->title) {
            $title = $fieldset->elementFactory->createFromExpression('div.decorateTitle');
            $title->addChild('<h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#' . $fieldset->getForm()->getId() . '" href="#collapse' . ucfirst($fieldset->getForm()->getId()) . $fieldset->getIndex() . '" aria-expanded="true" aria-controls="collapse' . ucfirst($fieldset->getForm()->getId()) . $fieldset->getIndex() . '">' . $this->title . '</a></h4>')
                ->addClass('panel-heading')->setAttribute('role', 'tab')->setId('heading' . ucfirst($fieldset->getForm()->getId()) . $fieldset->getIndex());
            $fieldset->prependChild($title);
        }
    }

    /**
     * @param $fieldset
     */
    protected function decorateHeading($fieldset)
    {
        $fieldset->addClass('panel panel-default decorateHeading');

        $fieldsetForm = $fieldset->findChild('form');

        $panelCollapse = $fieldset->elementFactory->createFromExpression('div#collapse' . ucfirst($fieldset->getForm()->getId()) . $fieldset->getIndex() . '.panel-collapse collapse')->setAttribute('role', 'tabpanel')->setAttribute('aria-labelledby', 'heading' . ucfirst($fieldset->getForm()->getId()) . $fieldset->getIndex());
        $panelBody = $fieldset->elementFactory->createFromExpression('div.panel-body')->setDecoratedParent($panelCollapse);

        if ($fieldsetForm instanceof Form) {
            $fieldsetForm->pushDecoratedParent($panelBody);
        } else {
            $arrChildren = $fieldset->removeChildren('*');
            foreach ($arrChildren as $child) {
                $panelBody->addChild($child);
            }
            $fieldset->addChild($panelBody);
        }
    }

}