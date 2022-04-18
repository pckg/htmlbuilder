<?php

namespace Pckg\Htmlbuilder\Validator;

use Pckg\Htmlbuilder\Element;

/**
 * Class AbstractBitwiseValidator
 *
 * @package Pckg\Htmlbuilder\Validator
 * @method addMsg(string $msg)
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
     *
     * @return bool
     */
    public function validate($value)
    {
        $this->errors = [];

        foreach ($this->arrBitwise as $bitwise => $arrBitwise) {
            if ($this->bitwise & $bitwise) {
                if (!$this->{'validate' . $arrBitwise['function']}()) {
                    $this->addMsg($arrBitwise['msg']);
                }
            }
        }

        return !$this->errors;
    }

    /**
     * @return $this|bool
     */
    protected function addBitwiseByFunction($function, $args)
    {
        foreach ($this->arrBitwise as $bit => $arrBitwise) {
            if ($arrBitwise['function'] == $function) {
                $this->addBitwise($bit, $args);

                return $this;
            }
        }

        return false;
    }

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
     * @return bool|null
     */
    protected function getBitByFunction($function)
    {
        foreach ($this->arrBitwise as $bit => $arrBitwise) {
            if ($arrBitwise['function'] == $function) {
                return array_key_exists($bit, $this->bitwiseValues)
                    ? $this->bitwiseValues[$bit]
                    : null;
            }
        }

        return false;
    }
}
