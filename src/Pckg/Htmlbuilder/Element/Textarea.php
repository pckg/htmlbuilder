<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Textarea
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Textarea extends Element
{

    use Labeled;

    /**
     * @var string
     */
    protected $tag = 'textarea';

    /**
     * @param null $value
     *
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
