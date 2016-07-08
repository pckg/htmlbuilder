<?php

namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Element;

/**
 * Class Children
 *
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Children
{

    /**
     * @var array
     */
    protected $children = [];

    /**
     * @param $children
     *
     * @return $this
     */
    public function addChildren($children)
    {
        foreach ($children AS $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * @param $child
     *
     * @return $this
     */
    public function addChild($child)
    {
        $this->children[] = $child;

        if ($child instanceof Element) {
            $child->transferFromElement($this);
        }

        return $this;
    }

    /**
     * @param $child
     *
     * @return $this
     */
    public function prependChild($child)
    {
        array_unshift($this->children, $child);

        return $this;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        if (!is_array($children)) {
            $children = [$children];
        }

        $this->children = $children;

        return $this;
    }

    /**
     * @param $index
     *
     * @return $this
     */
    public function unsetChild($index)
    {
        if (isset($this->children[$index])) {
            unset($this->children[$index]);
        }

        return $this;
    }

}