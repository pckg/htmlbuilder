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

    protected $uploadable = true;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = [
            'decorate',
            'setUploadable',
        ];
    }

    public function overloadSetUploadable(callable $next, AbstractObject $context)
    {
        $this->uploadable = $context->getArg(0);

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
        } else if ($tag == 'textarea') {
            $this->decorateTextarea($element);
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

        if ($element->getAttribute('type') == 'file' && $this->uploadable) {
            $type = $element->getAttribute('data-type');
            if ($type == 'picture') {
                $decoratedParent->addChild(
                    '<pckg-htmlbuilder-dropzone :current="\'' . $element->getAttribute('data-image') . '\'" ' .
                    ':url="\'' . $element->getAttribute('data-url') . '\'"
                    id="dynamic-dropzone-' . $element->getAttribute('id') . '"></pckg-htmlbuilder-dropzone>'
                );
            } elseif (in_array($type, ['file', 'pdf'])) {
                $decoratedParent->addChild(
                    '<pckg-htmlbuilder-dropzone :current="\'' . $element->getAttribute('data-' . $type) . '\'" ' .
                    ':url="\'' . $element->getAttribute('data-url') . '\'"
                    id="dynamic-dropzone-' . $element->getAttribute('id') . '"></pckg-htmlbuilder-dropzone>'
                );
            }
        }

        if ($element->getTag() == 'select') {
            $decoratedParent->addChild(
                '<pckg-htmlbuilder-select :url="\'' . $element->getAttribute('data-url') .
                '\'" :view-url="\'' . $element->getAttribute('data-view-url') .
                '\'" :refresh-url="\'' . $element->getAttribute('data-refresh-url') .
                '\'"></pckg-htmlbuilder-select>'
            );
            $element->addClass("pckg-selectpicker");
            $element->setAttribute("data-live-search", "true");
        }

        if ($element->hasClass('geo')) {
            $decoratedParent->addChild('<pckg-htmlbuilder-geo v-model="form.' . $element->getName() . '"></pckg-htmlbuilder-geo>');
        }
    }

    protected function decorateTextarea($element)
    {
        if ($element->hasClass('editor')) {
            $decoratedParent = $element->getDecoratedParent();
            $label = $decoratedParent->findChild('label');
            if (!$label) {
                $label = $decoratedParent;
            }
            $label->addChild(
                '<button type="button" class="pckg-editor-toggle btn btn-xs btn-default" @click.prevent="toggleEditor(\'' . $element->getAttribute('name') . '\')">Turn Editor On/Off</button>'
            );
        }
    }

}