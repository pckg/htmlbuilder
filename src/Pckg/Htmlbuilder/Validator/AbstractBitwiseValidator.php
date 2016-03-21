<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Htmlbuilder\Element;

/**
 * Class AbstractBitwiseValidator
 * @package Pckg\Htmlbuilder\Validator
 */
class AbstractBitwiseValidator extends AbstractValidator
{

    /**
     * @var int
     */
    protected $bitwise = 0;
    /**
     * @var array
     */
    protected $bitwiseValues = [];
    /**
     * @var array
     */
    protected $arrBitwise = [];

    /**
     * @param Element $element
     * @param         $args
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

    /**
     * @param $function
     * @param $args
     * @return $this|bool
     */
    protected function addBitwiseByFunction($function, $args)
    {
        foreach ($this->arrBitwise AS $bit => $arrBitwise) {
            if ($arrBitwise['function'] == $function) {
                $this->addBitwise($bit, $args);

                return $this;
            }
        }

        return false;
    }

    /**
     * @param $bit
     * @param $values
     */
    protected function addBitwise($bit, $values)
    {
        $arrBitwise = $this->bitwise[$bit];

        if (isset($arrBitwise['exclude'])) {
            foreach ($arrBitwise['exclude'] as $excludeBit => $exclude) {
                $this->bitwise = $this->bitwise & (~$excludeBit);
                unset($this->bitwiseValues[$excludeBit]);
            }
        }

        if (isset($arrBitwise['include'])) {
            foreach ($arrBitwise['include'] as $includeBit => $include) {
                $this->bitwise = $this->bitwise ^ $includeBit;
            }
        }

        $this->bitwise ^ $bit;
        $this->bitwiseValues[$bit] = $values;
    }

    /**
     * @param $function
     * @return bool|null
     */
    protected function getBitByFunction($function)
    {
        foreach ($this->arrBitwise AS $bit => $arrBitwise) {
            if ($arrBitwise['function'] == $function) {
                return array_key_exists($bit, $this->bitwiseValues)
                    ? $this->bitwiseValues[$bit]
                    : null;
            }
        }

        return false;
    }

}