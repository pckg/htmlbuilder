<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator;

/**
 * Class Input
 * @package Pckg\Htmlbuilder\Element
 */
class Input extends Field
{

    /**
     * @var bool
     */
    protected $selfClosing = true;

    /**
     * @var string
     */
    protected $tag = 'input';

    /* <input ..> shortcuts */
    /**
     * @param $type
     * @return $this
     */
    function setType($type)
    {
        $this->setAttribute("type", $type);

        return $this;
    }

    /**
     * @return null
     */
    function getType()
    {
        return $this->getAttribute("type");
    }

    /**
     * @param bool $disabled
     * @return $this
     */
    function setDisabled($disabled = true)
    {
        if ($disabled) {
            $this->setAttribute('disabled', 'disabled');
        } else {
            $this->unsetAttribute('disabled');
        }

        return $this;
    }

    /**
     * @return bool
     */
    function isDisabled()
    {
        return !!$this->getAttribute('disabled');
    }

    /**
     * @param bool $readOnly
     * @return $this
     */
    function setReadOnly($readOnly = true)
    {
        if ($readOnly) {
            $this->setAttribute('readonly', 'readonly');
        } else {
            $this->unsetAttribute('readonly');
        }

        return $this;
    }

    /**
     * @return bool
     */
    function isReadOnly()
    {
        return !!$this->getAttribute('readonly');
    }
}