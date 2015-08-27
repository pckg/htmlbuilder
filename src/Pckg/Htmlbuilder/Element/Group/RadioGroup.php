<?php

namespace Pckg\Htmlbuilder\Element\Group;

use Pckg\Htmlbuilder\Element;

/**
 * Class RadioGroup
 * @package Pckg\Htmlbuilder\Element\Group
 */
class RadioGroup extends Element\Group
{

    /**
     * @var array
     */
    protected $classes = ['row', 'group', 'radio-group'];

    /**
     * @param $value
     * @param $label
     * @return mixed
     */
    public function addOption($value, $label)
    {
        $option = $this->elementFactory->create('Radio');

        $this->addChild($option);

        $option->setValue($value);
        $option->setLabel($label);
        $option->setName($this->getName());

        return $option;
    }

    /**
     * @param $arrOptions
     * @return $this
     */
    public function addOptions($arrOptions)
    {
        foreach ($arrOptions as $key => $val) {
            $this->addOption($key, $val);
        }

        return $this;
    }

}