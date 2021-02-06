<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;

/**
 * Class Post
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Post extends AbstractDecorator
{

    /**
     *
     */
    protected function initOverloadMethods()
    {
        parent::initOverloadMethods();

        $this->mergeOverloadMethods(['decorate', 'isValidPost', 'isSubmitted']);
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadIsValid(callable $next, AbstractObject $context)
    {
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

        if ($element->getTag() == 'form') {
            $fieldset = $element->addFieldset();
            $fieldset->addHidden('_form')
                     ->setValue($element->getName())
                     ->setDecoratable(false);
        }

        return $next();
    }

    /**
     * @param AbstractObject $context
     *
     * @return bool
     */
    public function overloadIsValidPost(callable $next, AbstractObject $context)
    {
        $form = $context->getElement();

        return $this->overloadIsSubmitted($context) && $form->isValid();
    }

    /**
     * @param AbstractObject $context
     *
     * @return bool
     */
    public function overloadIsSubmitted(callable $next, AbstractObject $context)
    {
        return isset($_POST['_form']) && $_POST['_form'] == $context->getElement()->getName();
    }

    /**
     * @param $args
     *
     * @return array
     */
    public function fetchPost($args)
    {
        if (!$_POST) {
            return [];
        }

        return $args[0];
    }
}
