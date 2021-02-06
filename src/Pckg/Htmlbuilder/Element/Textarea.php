<?php

namespace Pckg\Htmlbuilder\Element;

/**
 * Class Textarea
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Textarea extends Field
{

    /**
     * @var string
     */
    protected $tag = 'textarea';

    /**
     * @param null $value
     *
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->setChildren((string)$value);

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return implode($this->getChildren());
    }
}
