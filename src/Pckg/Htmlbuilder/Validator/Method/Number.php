<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Concept\AbstractObject;
use Pckg\Htmlbuilder\Element;

/**
 * Class Number
 *
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Number extends Text
{

    /**
     * @var array
     */
    protected $msgs = [];

    // bitwise ...
    /**
     * @var
     */
    protected $bitwise = 0;

    protected $value;

    protected $min;

    protected $max;

    protected $below;

    protected $above;

    /**
     * @var array
     */
    protected $arrBitwise = [
        // types
        1   => [
            'msg'      => 'Must be integer',
            'function' => 'Int',
            'exclude'  => ['Float'],
        ],
        2   => [
            'msg'      => 'Must be float',
            'function' => 'Float',
            'include'  => ['Int'],
        ],
        4   => [
            'msg'      => 'Must be numeric',
            'function' => 'Numeric',
            'exclude'  => ['Float', 'Int'],
        ],
        // ranges
        8   => [
            'msg'      => 'Must be negative',
            'function' => 'Negative',
            'exclude'  => ['Below', 'Min'],
        ],
        16  => [
            'msg'      => 'Must be positive',
            'function' => 'Positive',
            'exclude'  => ['Above', 'Min'],
        ],
        // ranges
        32  => [
            'msg'      => 'Must be lower than ',
            'function' => 'Below',
            'exclude'  => ['Min'],
        ],
        64  => [
            'msg'      => 'Must be higher than ',
            'function' => 'Above',
            'exclude'  => ['Max'],
        ],
        // ranges
        128 => [
            'msg'      => 'Must be higher or equals ',
            'function' => 'Min',
            'exclude'  => ['Above'],
        ],
        256 => [
            'msg'      => 'Must be lower or equals ',
            'function' => 'Max',
            'exclude'  => ['Below'],
        ],
    ];

    public function initOverloadMethods()
    {
        parent::initOverloadMethods();

        $this->mergeOverloadMethods(['min', 'max', 'above', 'below', 'isValid']);
    }

    public function overloadIsValid(callable $next, AbstractObject $context)
    {
        $valid = $this->validate($context->getElement()->getValue());

        if (!$valid) {
            return false;
        }

        return $next();
    }

    public function overloadMin(callable $next, AbstractObject $object)
    {
        $this->bitwise += 128;
        $this->min = $object->getArg(0);

        return $next();
    }

    public function overloadMax(callable $next, AbstractObject $object)
    {
        $this->bitwise += 256;
        $this->max = $object->getArg(0);

        return $next();
    }

    public function overloadAbove(callable $next, AbstractObject $object)
    {
        $this->bitwise += 64;
        $this->above = $object->getArg(0);

        return $next();
    }

    public function overloadBelow(callable $next, AbstractObject $object)
    {
        $this->bitwise += 32;
        $this->below = $object->getArg(0);

        return $next();
    }

    /**
     * @return bool
     */
    public function validateMin()
    {
        return $this->value >= $this->min;
    }

    /**
     * @return bool
     */
    public function validateMax()
    {
        return $this->value <= $this->max;
    }

    /**
     * @return bool
     */
    public function validateBelow()
    {
        return $this->value < $this->below;
    }

    /**
     * @return bool
     */
    public function validateAbove()
    {
        return $this->value > $this->above;
    }

    // number

    /**
     * @return bool
     */
    protected function validateInt()
    {
        return is_int($this->value);
    }

    /**
     * @return bool
     */
    protected function validateFloat()
    {
        return is_float($this->value);
    }

    /**
     * @return bool
     */
    protected function validateNumeric()
    {
        return is_numeric($this->value);
    }

    /**
     * @param Element $element
     * @param         $args
     *
     * @return bool
     */
    public function validate($value)
    {
        if (!$this->bitwise) {
            return true;
        }

        $this->msgs = [];
        $this->value = $value;

        foreach ($this->arrBitwise as $bitwise => $arrBitwise) {
            if ($this->bitwise & $bitwise) {
                if (!$this->{'validate' . $arrBitwise['function']}()) {
                    $this->msgs[] = $arrBitwise['msg'] . (substr($arrBitwise['msg'], -1) == ' ' ? $this->{strtolower($arrBitwise['function'])} : '');
                }
            }
        }

        return !$this->msgs;
    }
}
