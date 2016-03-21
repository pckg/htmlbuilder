<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Select
 * @package Pckg\Htmlbuilder\Element
 */
class Select extends Element
{

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
     * @param null $value
     * @return $this
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        $this->setSelected($value);

        return $this;
    }

    /**
     * @param $value
     */
    public function setSelected($value)
    {
        foreach ($this->children AS $child) {
            $child->setSelected($child->getValue() == $value);
        }
    }

    /**
     * @param     $arrOptions
     * @param int $depth
     */
    public function addTreeOptions($arrOptions, $depth = 0)
    {

        foreach ($arrOptions AS $option) {
            $this->addOptions([
                $option->getId() => (!$depth ? '' : (str_repeat('=&nbsp;&nbsp;',
                            $depth) . ' ')) . ($option->getTitle() ?: $option->getSlug() . ' #' . $option->getId())
            ]);
            $this->addTreeOptions($option->getChildren, $depth + 1);
        }
    }

    /**
     * @param $options
     * @return $this
     */
    public function addOptions($options)
    {
        foreach ($options AS $key => $option) {
            $this->addOption($key, $option, $key == $this->value);
        }

        return $this;
    }

    /**
     * @param      $key
     * @param null $value
     * @param bool $selected
     * @return $this
     */
    public function addOption($key, $value = null, $selected = false)
    {
        if (is_object($key)) {
            $this->addChild($key);
        } else {
            $option = $this->elementFactory->create('Option');
            $option->setValue($key);
            $option->addChild($value);
            if ($selected || $key == $this->value) {
                $option->setAttribute('selected', 'selected');
            }
            $this->addChild($option);
        }

        return $this;
    }
}