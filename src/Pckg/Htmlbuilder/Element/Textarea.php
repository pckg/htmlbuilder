<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Textarea
 * @package Pckg\Htmlbuilder\Element
 */
class Textarea extends Element
{

    /**
     * @var string
     */
    protected $tag = 'textarea';

    /**
     * @param null $value
     * @return $this
     */
    function setValue($value = null)
    {
        $this->setChildren((string)$value);

        return $this;
    }

    /**
     * @return string
     */
    function getValue()
    {
        return implode($this->getChildren());
    }
}
