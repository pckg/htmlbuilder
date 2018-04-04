<?php namespace Pckg\Htmlbuilder\Snippet\Buildable;

use Pckg\Htmlbuilder\Element\Input\Radio;

trait Radioable
{

    public function addOptions($options, callable $callback = null)
    {
        foreach ($options as $key => $option) {
            $o = $this->addOption($key, $option, $key == $this->value);
            if ($callback) {
                $callback($o);
            }
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

    /**
     * @return Radio
     */
    public function addRadio()
    {
        $element = $this->elementFactory->create(Radio::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

}