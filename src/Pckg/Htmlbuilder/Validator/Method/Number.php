<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\Method\Text;

/**
 * Class Number
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
    protected $bitwise;
    /**
     * @var array
     */
    protected $arrBitwise = [
        // types
        1 => [
            'msg' => 'Must be integer',
            'function' => 'Int',
            'exclude' => ['Float'],
        ],
        2 => [
            'msg' => 'Must be float',
            'function' => 'Float',
            'include' => ['Int'],
        ],
        4 => [
            'msg' => 'Must be numeric',
            'function' => 'Numeric',
            'exclude' => ['Float', 'Int'],
        ],

        // ranges
        8 => [
            'msg' => 'Must be negative',
            'function' => 'Negative',
            'exclude' => ['Below', 'Min'],
        ],
        16 => [
            'msg' => 'Must be positive',
            'function' => 'Positive',
            'exclude' => ['Above', 'Min'],
        ],

        // ranges
        32 => [
            'msg' => 'Must be lower than ',
            'function' => 'Below',
            'exclude' => ['Min'],
        ],
        64 => [
            'msg' => 'Must be higher than ',
            'function' => 'Above',
            'exclude' => ['Max'],
        ],

        // ranges
        128 => [
            'msg' => 'Must be lower or equals',
            'function' => 'Min',
            'exclude' => ['Below'],
        ],
        256 => [
            'msg' => 'Must be higher or equal ',
            'function' => 'Max',
            'exclude' => ['Above'],
        ],
    ];

    // overload text

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
        return $this->value >= $this->max;
    }

    /**
     * @return bool
     */
    public function validateBelow()
    {
        return $this->value >= $this->below;
    }

    /**
     * @return bool
     */
    public function validateAbove()
    {
        return $this->value >= $this->above;
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
     * @param $args
     * @return bool
     */
    public function validate(Element $element, $args)
    {
        $this->errors = [];
        $this->value = $element->getValue();

        foreach ($this->arrBitwise AS $bitwise => $arrBitwise) {
            if ($this->bitwise & $bitwise) {
                if (!$this->{'validate' . $arrBitwise['function']}()) {
                    $this->addMsg($arrBitwise['msg']);
                }
            }
        }

        return !$this->errors;
    }

}