<?php

namespace Pckg\Htmlbuilder\Decorator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Decorator;
use Pckg\Htmlbuilder\Decorator\AbstractDecorator;
use Pckg\Htmlbuilder\Element;

/**
 * Class Record
 *
 * @package Pckg\Htmlbuilder\Decorator\Method
 */
class Record extends AbstractDecorator
{

    /**
     * @var bool
     */
    protected $recursive = true;

    /**
     * @var
     */
    protected $record;

    /**
     *
     */
    protected function initOverloadMethods()
    {
        $this->methods = ['decorate', 'setRecords'];
    }

    /**
     * @param AbstractObject $context
     *
     * @return mixed
     */
    public function overloadSetRecord(callable $next, AbstractObject $context)
    {
        $this->record = $context->getArg(0);
        $element = $context->getElement();

        if ($element->getTag() == 'form') {
            $element->setID(lcfirst('form' . str_replace(['\\', 'Record'], '', get_class($this->record))));
            $element->setName($element->getID());
        }

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

        $this->decorateID($element);
        $this->decorateName($element);

        return $next();
    }

    /**
     * @param $element
     */
    public function decorateName($element)
    {
        if (
            in_array(
                $element->getTag(),
                ['input', 'button', 'select', 'textarea']
            ) && !in_array(
                $element->getAttribute('type'),
                ['submit', 'cancel']
            ) && $this->record
        ) {
            $name = lcfirst(
                str_replace(
                    ['\\', 'Record'],
                    '',
                    get_class($this->record)
                )
            ) . '[' . $element->getName() . ']';
            $element->setName($name);
        }
    }

    /**
     * @param $element
     *
     * @return mixed
     */
    public function decorateID($element)
    {
        if (in_array($element->getTag(), ['input', 'button', 'select', 'textarea']) && $this->record) {
            $append = $element->getName()
                ? '_' . $element->getName()
                : '';
            $element->setID(lcfirst(str_replace(['\\', 'Record'], '', get_class($this->record)) . $append));
        }

        return $element;
    }
}
