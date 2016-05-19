<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Wrapper;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Input\Hidden;

/*
 * Bootstrap decorator encapsulates elements in Bootstrap wrappers and classes
 * */

/**
 * Class Bootstrap
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Bootstrap extends AbstractDecorator
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /*
     * We add label if it is set
     * @setter, @chain - setLabel($label)
     *
    */
    /**
     * @var
     */
    protected $label;
    /**
     * @var
     */
    protected $help;
    /**
     * @var bool
     */
    protected $wrapped = true;
    /**
     * @var bool
     */
    protected $grouped = true;

    /**
     * @var string
     */
    protected $formGroupClass = 'form-group';
    /**
     * @var string
     */
    protected $labelClass = 'col-sm-3';

    /**
     * @var string
     */
    protected $fieldClass = 'col-sm-9';

    /**
     * @var string
     */
    protected $fullFieldClass = 'col-sm-12';

    /**
     * @var string
     */
    protected $offsetClass = 'col-sm-offset-3';
    /**
     * @var string
     */
    protected $offsetFieldClass = 'col-sm-offset-3';
    /**
     * @var string
     */
    protected $offsetFullFieldClass = 'col-sm-offset-3';

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [
            'decorate',
            'setLabel',
            'setHelp',
            'setDecoratorClasses',
            'setWrapped',
            'setGrouped',
        ];
    }

    /**
     *
     */
    public function __clone()
    {
        $this->label = null;
        $this->help = null;
    }

    /*
     *
     * @return \Htmlbuider\AbstractDecorator
     */
    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetDecoratorClasses(callable $next, AbstractObject $context)
    {
        $classes = $context->getArg(0);

        foreach ($classes AS $class => $value) {
            if (property_exists($this, $class . 'Class')) {
                $this->{$class . 'Class'} = $value;
            }
        }

        return $next();
    }

    /*
     * Catches 'setLabel' on element and executes next link/chain.
     * */
    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetLabel(callable $next, AbstractObject $context)
    {
        $this->label = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetHelp(callable $next, AbstractObject $context)
    {
        $this->help = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetWrapped(callable $next, AbstractObject $context)
    {
        $this->wrapped = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadSetGrouped(callable $next, AbstractObject $context)
    {
        $this->grouped = $context->getArg(0);

        return $next();
    }

    /*
     * Decorator logic
     * */
    /**
     * @param AbstractObject $context
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if (in_array($element->getTag(),
                ['input', 'select', 'button', 'textarea']) && $element->getAttribute('type') != 'hidden'
        ) {
            $this->decorateParent($element);

        } else if (in_array($element->getTag(), ['div'])) {
            if ($element instanceof Element\Group) {
                $this->decorateGroup($element);
            }

        }

        return $next();
    }

    /**
     * @param $element
     * @return mixed
     */
    public function decorateParent($element)
    {
        $tag = $element->getTag();
        $type = $element->getType();

        if ($tag == 'input' && $type == 'checkbox') {
            $this->decorateCheckbox($element);

        } else if ($tag == 'input' && $type == 'radio') {
            $this->decorateRadio($element);

        } else if ($tag == 'input' && in_array($type, ['button', 'submit', 'reset'])) {
            $this->decorateButton($element);

        } else {
            $this->decorateField($element);

        }

        return $element;
    }

    /**
     * @return string
     */
    protected function getFieldClassByLabel()
    {
        return $this->label
            ? $this->fieldClass
            : $this->fullFieldClass;
    }

    /**
     * @param $element
     */
    protected function decorateField($element)
    {
        $element->addClass('form-control');

        if ($this->wrapped) {
            $bootstrapDiv = $this->elementFactory
                ->createFromExpression('div.' . $this->getFieldClassByLabel());
            $element->setDecoratedParent($bootstrapDiv);
        }

        if ($this->grouped) {
            $formGroup = $this->elementFactory->createFromExpression('div.' . $this->formGroupClass);
            $formGroup->addClass('grouped');

            if ($this->label) {
                $this->decorateLabel($element, $formGroup);
            }

            if ($this->wrapped) {
                $bootstrapDiv->setDecoratedParent($formGroup);
            } else {
                $element->setDecoratedParent($formGroup);
            }
        } else {
            $element->setDecoratedParent($bootstrapDiv);
        }

        if ($element->getAttribute('type') == 'file' && $value = $element->getValue()) {
            $bootstrapDiv->addChild('<img src="' . $value . '" class="img-responsive col-lg-2" />');
        }

        if ($element->getTag() == 'select') {
            $element->addClass("selectpicker");
            $element->setAttribute("data-live-search", "true");
        }
    }

    /**
     * @return string
     */
    protected function getFullFieldClassWithOffset()
    {
        return $this->fullFieldClass . ' ' . $this->offsetFullFieldClass;
    }

    /**
     * @param $element
     */
    protected function decorateCheckbox($element)
    {
        $checkboxDiv = $this->elementFactory->createFromExpression("div.checkbox");
        $labelWrapper = $this->wrapIntoLabel($element);

        if ($this->wrapped) {
            $bootstrapDiv = $this->elementFactory
                ->createFromExpression('div.' . $this->getFullFieldClassWithOffset());
            $checkboxDiv->setDecoratedParent($bootstrapDiv);
        }

        if (!$this->grouped) {
            $formGroupWrapper = $this->elementFactory->createFromExpression('div')->addClass($this->formGroupClass);

            if ($this->wrapped) {
                $bootstrapDiv->setDecoratedParent($formGroupWrapper);
            } else {
                $checkboxDiv->setDecoratedParent($formGroupWrapper);
            }
        } else {
            if ($this->wrapped) {
                $checkboxDiv->setDecoratedParent($bootstrapDiv);
            } else {

            }
        }

        $labelWrapper->setDecoratedParent($checkboxDiv);

        $this->addHiddenForCheckbox($element, $labelWrapper);

        if (!$element->getValue()) {
            $element->setValue(1);
        }
    }

    /**
     * @param Element $element
     * @return mixed|object
     */
    protected function wrapIntoLabel(Element $element)
    {
        $wrapper = $this->elementFactory->create("Label");
        if ($id = $element->getAttribute('id')) {
            $wrapper->setAttribute('for', $id);
        }

        if ($this->label) {
            $element->addSibling($this->label);
        }

        $element->setDecoratedParent($wrapper);

        return $wrapper;
    }

    /**
     * @param Element $element
     * @param Element $wrapper
     * @return mixed|object
     */
    protected function addHiddenForCheckbox(Element $element, Element $wrapper)
    {
        $hidden = $this->elementFactory->create("Hidden");
        $hidden->setName($element->getName())->setValue(null);
        $wrapper->addChild($hidden);

        return $hidden;
    }

    /**
     * @param $element
     */
    protected function decorateRadio($element)
    {
        $outerDiv = $this->elementFactory->create('Div');
        $outerDiv->addClass($this->formGroupClass);

        $label = $this->elementFactory->create("Label");

        if ($id = $element->getAttribute('id')) {
            $label->setAttribute('for', $id);
        }

        $checkboxDiv = $this->elementFactory->create("Div");
        $checkboxDiv->addClass('radio');

        $label->setDecoratedParent($checkboxDiv);

        if ($this->label) {
            $element->addSibling($this->label);
        }

        $element->setDecoratedParent($label);

        if (!$element->getValue()) {
            $element->setValue(1);
        }
    }

    /**
     * @param $element
     * @param $div
     */
    protected function decorateLabel($element, $div)
    {
        $label = $this->elementFactory->create("Label");
        $label->addClass($this->labelClass)->addChild($this->label);

        if ($this->help) {
            $help = $this->elementFactory->create("Div");
            $help->addClass('help')->addChild('<button type="button" class="btn btn-info btn-xs" data-toggle="popover" data-trigger="focus" title="Help" data-content="' . $this->help . '" data-placement="top" data-container="body">?</button>');

            $label->addChild($help);
        }

        if ($id = $element->getAttribute('id')) {
            $label->setAttribute('for', $id);
        }

        $div->addChild($label);
    }

    /**
     * @param $element
     */
    protected function decorateButton($element)
    {
        $element->addClass('btn btn-default');
    }

    /**
     * @param $element
     */
    protected function decorateGroup($element)
    {
        if (!$this->label) {
            return;
        }

        $outerDiv = $this->elementFactory->create('Div');
        $outerDiv->addClass($this->formGroupClass);

        if ($this->label) {
            $this->decorateLabel($element, $outerDiv);
        }

        $bootstrapDiv = $this->elementFactory->create('Div');
        $bootstrapDiv->addClass($this->label ? $this->fieldClass : $this->fullFieldClass)->setDecoratedParent($outerDiv);

        $element->setDecoratedParent($bootstrapDiv);
    }
}