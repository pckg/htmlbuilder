<?php

namespace Pckg\Htmlbuilder\Element\Select;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\AttributeValue;

/**
 * Class Option
 *
 * @package Pckg\Htmlbuilder\Element\Select
 */
class Option extends Element
{

    /**
     * @var array
     */
    protected $options = [];

    /**
     *
     */
    public function __construct()
    {
        $this->setTag('option');
    }

    /**
     * @param $selected
     */
    public function setSelected($selected)
    {
        if ($selected) {
            $this->setAttribute('selected', 'selected');
        } else {
            $this->unsetAttribute('selected');
        }
    }

    /**
     * @param null $value
     *
     * @return $this
     */
    public function setValue($value = null)
    {
        parent::setValue($value);

        $this->setAttribute('value', $value);

        if (!$value) {
            $this->a(':value', 'null');
        }

        return $this;
    }
}
