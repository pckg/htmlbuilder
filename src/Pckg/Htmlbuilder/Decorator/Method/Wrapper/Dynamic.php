<?php

namespace Pckg\Htmlbuilder\Decorator\Method\Wrapper;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Input\Hidden;

/**
 * Class Dynamic
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Dynamic extends AbstractDecorator
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [
            'decorate',
        ];
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadDecorate(callable $next, AbstractObject $context)
    {
        $element = $context->getElement();

        if (in_array(
                $element->getTag(),
                ['input', 'select', 'button', 'textarea']
            ) && $element->getAttribute('type') != 'hidden'
        ) {
            $this->decorateParent($element);

        }

        return $next();
    }

    /**
     * @param $element
     *
     * @return mixed
     */
    public function decorateParent($element)
    {
        $tag = $element->getTag();
        $type = $element->getType();

        if ($tag == 'input' && $type == 'checkbox') {

        } else if ($tag == 'input' && $type == 'radio') {

        } else if ($tag == 'input' && in_array($type, ['button', 'submit', 'reset'])) {

        } else {
            $this->decorateField($element);

        }

        return $element;
    }

    /**
     * @param $element
     */
    protected function decorateField($element)
    {
        $decoratedParent = $element->getDecoratedParent();

        if ($element->getAttribute('type') == 'file') {
            $type = $element->getAttribute('data-type');
            if ($type == 'picture') {
                $decoratedParent->addChild(
                    '<pckg-htmlbuilder-dropzone :current="\'' . $element->getAttribute('data-image') . '\'" ' .
                    ':url="\'' . $element->getAttribute('data-url') . '\'"></pckg-htmlbuilder-dropzone>'
                );
            } elseif (in_array($type, ['file', 'pdf'])) {
                $decoratedParent->addChild(
                    '<pckg-htmlbuilder-dropzone :current="\'' . $element->getAttribute('data-' . $type) . '\'" ' .
                    ':url="\'' . $element->getAttribute('data-url') . '\'"></pckg-htmlbuilder-dropzone>'
                );

            }
        }

        if ($element->getTag() == 'select') {
            $decoratedParent->addChild('<pckg-htmlbuilder-select></pckg-htmlbuilder-select>');
        }
    }

}