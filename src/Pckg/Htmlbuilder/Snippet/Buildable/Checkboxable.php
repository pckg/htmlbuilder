<?php namespace Pckg\Htmlbuilder\Snippet\Buildable;

use Pckg\Htmlbuilder\Element\Input\Checkbox;

trait Checkboxable
{

    protected $values = [];

    /**
     * @return Checkbox
     */
    public function addCheckbox()
    {
        $element = $this->elementFactory->create(Checkbox::class, func_get_args());

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

    /**
     * @param      $key
     * @param      $value
     * @param bool $checked
     * @return Checkbox
     */
    public function addOption($key, $value, $checked = null)
    {
        $checkbox = null;
        if (is_object($key)) {
            $this->addChild($key);
            $checkbox = $key;
        } else {
            $checkbox = $this->addCheckbox();
            $checkbox->setName($this->getName());
        }

        if ($checked || in_array($value, $this->values)) {
            $checkbox->setAttribute('checked', 'checked');
        }

        return $checkbox;
    }

}