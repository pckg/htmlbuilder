<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Wrapper;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;

/*
 * Bootstrap decorator encapsulates elements in Bootstrap wrappers and classes
 * */

/**
 * Class Bootstrap
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Bootstrap extends AbstractDecorator
{
    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $help;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var string
     */
    protected $suffix;

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
     * @var string
     */
    protected $labelType = 'label';

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [
            'decorate',
            'setLabel',
            'setLabelType',
            'getLabel',
            'setHelp',
            'getHelp',
            'setDecoratorClasses',
            'setWrapped',
            'setGrouped',
            'setPrefix',
            'setSuffix',
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

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetDecoratorClasses(callable $next, AbstractObject $context)
    {
        $classes = $context->getArg(0);

        foreach ($classes as $class => $value) {
            if (property_exists($this, $class . 'Class')) {
                $this->{$class . 'Class'} = $value;
            }
        }

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetLabel(callable $next, AbstractObject $context)
    {
        $this->label = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetLabelType(callable $next, AbstractObject $context)
    {
        $this->labelType = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadGetLabel(callable $next, AbstractObject $context)
    {
        return $this->label;
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetHelp(callable $next, AbstractObject $context)
    {
        $this->help = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadGetHelp(callable $next, AbstractObject $context)
    {
        return $this->help;
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetPrefix(callable $next, AbstractObject $context)
    {
        $this->prefix = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetSuffix(callable $next, AbstractObject $context)
    {
        $this->suffix = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetWrapped(callable $next, AbstractObject $context)
    {
        $this->wrapped = $context->getArg(0);

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetGrouped(callable $next, AbstractObject $context)
    {
        $this->grouped = $context->getArg(0);

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

        if (
            in_array(
                $element->getTag(),
                ['input', 'select', 'button', 'textarea']
            ) && $element->getAttribute('type') != 'hidden'
        ) {
            $this->decorateParent($element);
        } else if (in_array($element->getTag(), ['div', 'fieldset'])) {
            if ($element instanceof Element\Field) {
                $this->decorateParent($element);
            } elseif ($element instanceof Element\Group) {
                $this->decorateGroup($element);
            } elseif ($element instanceof Element\Div) {
                $this->decorateGroup($element);
            } elseif ($element instanceof Element\Fieldset) {
                $this->decorateGroup($element);
            }
        } else if ($element->getTag() == 'pckg-select') {
            $this->decorateParent($element);
        }

        return $next();
    }

    /**
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
        return $this->label && $this->labelType == 'label'
            ? $this->fieldClass
            : $this->fullFieldClass;
    }

    protected function decorateField($element)
    {
        if ($element->getType() != 'checkbox' && !in_array($element->getTag(), ['select', 'pckg-select'])) {
            $element->addClass('form-control');
        }

        $bootstrapDiv = null;
        if ($this->wrapped) {
            $bootstrapDiv = $this->elementFactory
                ->createFromExpression('div.' . $this->getFieldClassByLabel());
            $element->setDecoratedParent($bootstrapDiv);

            if ($this->prefix) {
                $bootstrapDiv->addChild('<span class="input-group-addon">' . $this->prefix . '</span>');
                $bootstrapDiv->addClass('input-group');
            }

            if ($this->suffix) {
                $element->addSibling('<span class="input-group-addon">' . $this->suffix . '</span>');
                $bootstrapDiv->addClass('input-group');
            }
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
    }

    /**
     * @return string
     */
    protected function getFullFieldClassWithOffset()
    {
        return $this->fieldClass . ' ' . $this->offsetFullFieldClass;
    }

    protected function decorateCheckbox($element)
    {
        return $this->decorateField($element);
        $checkboxDiv = $this->elementFactory->createFromExpression("div.checkbox");
        $labelWrapper = $this->wrapIntoLabel($element);

        if ($this->wrapped) {
            $bootstrapDiv = $this->elementFactory
                ->createFromExpression('div.' . $this->getFullFieldClassWithOffset());
            $bootstrapDiv->addClass('wrapped');
            $checkboxDiv->setDecoratedParent($bootstrapDiv);
        }

        if (!$this->grouped) {
            $formGroup = $this->elementFactory->createFromExpression('div.' . $this->formGroupClass);
            $formGroup->addClass('non-grouped');

            if ($this->wrapped) {
                $bootstrapDiv->setDecoratedParent($formGroup);
            } else {
                $checkboxDiv->setDecoratedParent($formGroup);
            }
        } else {
            $formGroup = $this->elementFactory->createFromExpression('div.' . $this->formGroupClass);
            $formGroup->addClass('grouped');

            if ($this->wrapped) {
                $bootstrapDiv->setDecoratedParent($formGroup);
                //$checkboxDiv->setDecoratedParent($bootstrapDiv);
            } else {
            }
        }

        $labelWrapper->setDecoratedParent($checkboxDiv);

        $this->addHiddenForCheckbox($element, $labelWrapper);

        /*if ($this->help) {
            $help = $this->elementFactory->create("Div");
            $help->addClass('help')->addChild(
                '<button type="button" class="btn btn-info btn-xs btn-rounded" data-toggle="popover" data-trigger="focus" title="Help" data-content="' . $this->help . '" data-placement="top" data-container="body"><i class="fal fa-question" aria-hidden="true"></i></button>'
            );

            $labelWrapper->addChild($help);
        }*/

        if (!$element->getValue()) {
            $element->setValue(1);
        }
    }

    /**
     * @param Element $element
     *
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
     *
     * @return mixed|object
     */
    protected function addHiddenForCheckbox(Element $element, Element $wrapper)
    {
        $hidden = $this->elementFactory->create("Hidden");
        $hidden->setName($element->getName())->setValue(null);
        $wrapper->addChild($hidden);

        return $hidden;
    }

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

    protected function decorateLabel($element, $div)
    {
        if ($this->labelType == 'placeholder') {
            $element->setPlaceholder($this->label);
            $this->decorateHelp($element);

            return;
        }

        $label = $this->elementFactory->create("Label");
        $label->addClass($this->labelClass)->addChild($this->label);

        if ($id = $element->getAttribute('id')) {
            $label->setAttribute('for', $id);
        }

        $this->decorateHelp($element->getDecoratedParent());

        $div->addChild($label);
    }

    protected function decorateHelp($sibling)
    {
        if (!$this->help) {
            return;
        }

        $help = $this->elementFactory->create("Div");
        $help->addClass('help')->addChild(htmlspecialchars($this->help));

        $sibling->addSibling($help);
    }

    protected function decorateButton($element)
    {
        $element->addClass('btn btn-default');

        if ($element->getAttribute('type') == 'submit') {
            $element->addClass('btn-primary');
        } else if ($element->getAttribute('type') == 'reset') {
            $element->addClass('btn-warning');
        }
    }

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
        $bootstrapDiv->addClass($this->label ? $this->fieldClass : $this->fullFieldClass)->setDecoratedParent(
            $outerDiv
        );

        $element->setDecoratedParent($bootstrapDiv);
    }
}
