<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Validator\Method\Text;

/**
 * Class Datetime
 *
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Datetime extends Text
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
        1  => [
            'msg'      => 'Must be date',
            'function' => 'Date',
            'exclude'  => ['Datetime'],
        ],
        2  => [
            'msg'      => 'Must be time',
            'function' => 'Time',
            'exclude'  => ['Datetime'],
        ],
        4  => [
            'msg'      => 'Must be datetime',
            'function' => 'Datetime',
            'exclude'  => ['Date', 'Time'],
        ],
        // ranges
        8  => [
            'msg'      => 'Must be lower than ',
            'function' => 'Below',
            'exclude'  => ['Min'],
        ],
        16 => [
            'msg'      => 'Must be higher than ',
            'function' => 'Above',
            'exclude'  => ['Max'],
        ],
        // ranges
        32 => [
            'msg'      => 'Must be lower or equals',
            'function' => 'Min',
            'exclude'  => ['Below'],
        ],
        64 => [
            'msg'      => 'Must be higher or equal ',
            'function' => 'Max',
            'exclude'  => ['Above'],
        ],
    ];

    // overload text

    /**
     * @return bool
     */
    public function validateMin()
    {
        return is_null($this->min) || (int)$this->value >= $this->min;
    }

    /**
     * @return bool
     */
    public function validateMax()
    {
        return is_null($this->max) || (int)$this->value >= $this->max;
    }

    /**
     * @return bool
     */
    public function validateBelow()
    {
        return is_null($this->below) || (int)$this->value >= $this->below;
    }

    /**
     * @return bool
     */
    public function validateAbove()
    {
        return is_null($this->above) || (int)$this->value >= $this->above;
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
    public function validate(Element $element, $args)
    {
        $this->errors = [];
        $this->value = $element->getValue();

        foreach ($this->arrBitwise as $bitwise => $arrBitwise) {
            if ($this->bitwise & $bitwise) {
                if (!$this->{'validate' . $arrBitwise['function']}()) {
                    $this->addMsg($arrBitwise['msg']);
                }
            }
        }

        return !$this->errors;
    }
}
