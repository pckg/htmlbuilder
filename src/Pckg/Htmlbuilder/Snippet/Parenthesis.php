<?php

namespace Pckg\Htmlbuilder\Snippet;

trait Parenthesis
{
    /**
     * @var null
     */
    protected $parent = null;

    /**
     * @var null
     */
    protected $decoratedParent = null;

    /**
     * @return null
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function getTopParent()
    {
        return $this->getParent()
            ? $this->getParent()->getTopParent()
            : $this;
    }

    /**
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return $this
     */
    public function pushParent($parent)
    {
        if ($this->parent) {
            $parent->setParent($this->parent);
        }

        $this->parent = $parent;

        return $this;
    }

    /**
     * @return null
     */
    public function getDecoratedParent()
    {
        return $this->decoratedParent;
    }

    /**
     * @return $this
     */
    public function setDecoratedParent($parent)
    {
        $this->decoratedParent = $parent;

        return $this;
    }

    /**
     * @return $this
     */
    public function pushDecoratedParent($parent)
    {
        if ($this->decoratedParent) {
            $parent->setDecoratedParent($this->decoratedParent);
        }

        $this->decoratedParent = $parent;

        return $this;
    }
}
