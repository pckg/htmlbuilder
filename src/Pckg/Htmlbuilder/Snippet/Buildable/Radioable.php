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

    public function addOption($key, $value, $selected = null)
    {
        $radio = null;
        if (is_object($key)) {
            $this->addChild($key);
            $radio = $key;
        } else {
            $radio = $this->addRadio();
            $radio->setName($this->getName());
        }

        if ($selected || $value == $this->value) {
            $radio->setAttribute('selected', 'selected');
        }

        return $radio;
    }

}