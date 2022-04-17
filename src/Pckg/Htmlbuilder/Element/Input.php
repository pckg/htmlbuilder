<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator;

/**
 * Class Input
 *
 * @package Pckg\Htmlbuilder\Element
 * @method min(int|float $min)
 * @method max(int|float $min)
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

    /**
     * @param $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->setAttribute("type", $type);

        return $this;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->getAttribute("type");
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled($disabled = true)
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
    public function isDisabled()
    {
        return !!$this->getAttribute('disabled');
    }

    /**
     * @param bool $readOnly
     *
     * @return $this
     */
    public function readonly($readOnly = true)
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
    public function isReadonly()
    {
        return !!$this->getAttribute('readonly');
    }
}
