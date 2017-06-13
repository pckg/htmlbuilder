<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element\Select\Option;

/**
 * Class Select
 *
 * @package Pckg\Htmlbuilder\Element
 */
class OptionGroup extends Field
{

    /**
     * @var string
     */
    protected $tag = 'optgroup';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var Select
     */
    protected $select;

    /**
     * @param $options
     *
     * @return $this
     */
    public function addOptions($options)
    {
        if (is_only_callable($options)) {
            $options($this);
        } else {
            foreach ($options AS $key => $option) {
                $this->addOption($key, strip_tags($option), $key == $this->value);
            }
        }

        return $this;
    }

    /**
     * @param      $key
     * @param null $value
     * @param bool $selected
     *
     * @return $this
     */
    public function addOption($key, $value = null, $selected = false)
    {
        if (is_object($key)) {
            $this->addChild($key);

            return $key;
        } else {
            $option = $this->elementFactory->create(Option::class);
            $option->setValue($key);
            $option->addChild($value);

            if ($selected || ($this->select && $key == $this->select->getValue())) {
                $option->setAttribute('selected', 'selected');
            }

            $this->addChild($option);

            return $option;
        }
    }

    public function setSelect(Select $select)
    {
        $this->select = $select;

        return $this;
    }

}