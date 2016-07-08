<?php namespace Pckg\Htmlbuilder\Snippet\Buildable;

use Pckg\Htmlbuilder\Element\Input\Checkbox;

trait Checkboxable
{

    protected $values = [];

    public function addOptions($options)
    {
        foreach ($options as $key => $option) {
            $this->addOption($key, $option, $key == $this->value);
        }

        return $this;
    }

    /**
     * @param      $key
     * @param      $value
     * @param bool $checked
     *
     * @return Checkbox
     */
    public function addOption($value, $label = null, $checked = null)
    {
        $checkbox = null;
        if (is_object($value)) {
            $this->addChild($value);
            $checkbox = $value;
        } else {
            $checkbox = $this->addCheckbox();
            $checkbox->setName($this->getName() . '[]');
            $checkbox->setValue($value);
            $checkbox->setLabel($label);
        }

        if ($checked || in_array($value, $this->values)) {
            $checkbox->setAttribute('checked', 'checked');
        }

        return $checkbox;
    }

    /**
     * @return Checkbox
     */
    public function addCheckbox()
    {
        $element = $this->elementFactory->create(Checkbox::class, func_get_args());

        $this->addChild($element);

        return $element;
    }

}