<?php namespace Pckg\Htmlbuilder\Snippet\Buildable;

use Pckg\Htmlbuilder\Element\Input\Radio;

trait Radioable
{

    /**
     * @return Radio
     */
    public function addRadio()
    {
        $element = $this->elementFactory->create(Radio::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

    public function addOptions($options)
    {
        foreach ($options as $key => $option) {
            $this->addOption($key, $option, $key == $this->value);
        }

        return $this;
    }

    public function addOption($value, $label = null, $selected = null)
    {
        $radio = null;
        if (is_object($value)) {
            $this->addChild($value);
            $radio = $value;
        } else {
            $radio = $this->addRadio();
            $radio->setName($this->getName());
            $radio->setValue($value);
            $radio->setLabel($label);
        }

        if ($selected || $value == $this->value) {
            $radio->setAttribute('selected', 'selected');
        }

        return $radio;
    }

}