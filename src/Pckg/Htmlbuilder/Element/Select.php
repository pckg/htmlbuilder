<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element\Select\Option;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Select
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Select extends Field
{
    use Labeled;

    /**
     * @var string
     */
    protected $tag = 'select';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var null
     */
    protected $value = null;

    /**
     * @var null
     */
    protected $defaultValue = null;

    /**
     * @param null $value
     *
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        $this->setSelected($value);

        return $this;
    }

    public function setSelected($value)
    {
        foreach ($this->children as $child) {
            if ($child instanceof OptionGroup) {
                foreach ($child->getChildren() as $option) {
                    $option->setSelected($option->getValue() == $value);
                }
            } else {
                $child->setSelected($child->getValue() == $value);
            }
        }
    }

    /**
     * @param int $depth
     */
    public function addTreeOptions($arrOptions, $depth = 0)
    {

        foreach ($arrOptions as $option) {
            $this->addOptions(
                [
                    $option->getId() => (!$depth ? '' : (str_repeat(
                        '=&nbsp;&nbsp;',
                        $depth
                    ) . ' ')) .
                                        ($option->getTitle() ?: $option->getSlug() . ' #' . $option->getId()),
                ]
            );
            $this->addTreeOptions($option->getChildren, $depth + 1);
        }
    }

    /**
     * @return $this
     */
    public function addOptions($options)
    {
        if (is_only_callable($options)) {
            $options($this);
        } else {
            foreach ($options as $key => $option) {
                $this->addOption($key, strip_tags($option), $key == $this->value);
            }
        }

        return $this;
    }

    /**
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
            if ($value) {
                $option->addChild($value);
            }

            if ($selected || $key == $this->value) {
                $option->setAttribute('selected', 'selected');
            }

            $this->addChild($option);

            return $option;
        }
    }

    public function addOptionGroup($label = null)
    {
        $optionGroup = $this->elementFactory->create(OptionGroup::class);
        $this->addChild($optionGroup);

        if ($label) {
            $optionGroup->setAttribute('label', $label);
        }

        $optionGroup->setSelect($this);

        return $optionGroup;
    }

    public function multiple($multiple = true)
    {
        if ($multiple) {
            $this->setAttribute('multiple', 'multiple');
            $this->defaultValue = [];
        } else {
            $this->removeAttribute('multiple');
            $this->defaultValue = null;
        }

        if ($multiple && !is_array($this->value)) {
            $this->setValue($this->value ? (array)$this->value : []);
        } else if (!$multiple && is_array($this->value)) {
            $this->setValue((string)$this->value);
        }

        return $this;
    }
}
