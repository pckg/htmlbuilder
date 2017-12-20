<?php

namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Builder\AbstractBuilder;
use Pckg\Htmlbuilder\Builder\Classic;
use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Event\DecorationRequested;
use Pckg\Htmlbuilder\Event\PreDecorationRequested;
use Throwable;

/**
 * Class Builder
 *
 * @package Pckg\Htmlbuilder\Snippet
 */
trait Builder
{

    /**
     * @var null
     */
    protected $build = null;

    /**
     * @var null
     */
    public $html = null;

    /**
     * @var
     */
    protected $opened = false;

    /**
     * @var
     */
    protected $builder = Classic::class;

    /**
     * @return string
     */
    public function __toString()
    {
        // i think this needs to be this way because twig somehow calls __toString (renderBlock, displayBlock)
        if (!$this->html) {
            try {
                $this->toHTML();
            } catch (Throwable $e) {
                return '<!-- ' . $e->getMessage() . $e->getFile() . '-->';
            }
        }

        return (string)$this->html;
    }

    /**
     * @return bool
     */
    public function isOpened()
    {
        return $this->opened;
    }

    /**
     * @return bool
     */
    public function isSelfClosing()
    {
        return $this->selfClosing;
    }

    /**
     * @return AbstractBuilder
     */
    public function getBuilder()
    {
        if (is_string($this->builder)) {
            $builder = $this->builder;
            $this->builder = new $builder($this);
        }

        return $this->builder;
    }

    /**
     * @param AbstractBuilder $builder
     *
     * @return $this
     */
    public function setBuilder(AbstractBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @return string
     */
    public function buildElement()
    {
        return $this->getBuilder()->build($this);
    }

    public function open()
    {
        $this->opened = true;

        return $this->getBuilder()->buildBeforeElement();
    }

    public function close()
    {
        return $this->getBuilder()->buildAfterElement();
    }

    /*
    Builds childrens
    */
    /**
     * @param $siblings
     *
     * @return string
     * @throws \Exception
     */
    public function buildFromArray($siblings)
    {
        $html = "";

        foreach ($siblings AS $sibling) {
            $html .= $this->childToHTML($sibling)/* . "\n"*/
            ;
        }

        return $html;
    }

    /**
     * @param $child
     *
     * @return null|string
     * @throws \Exception
     */
    public function childToHTML($child)
    {
        $childrenHTML = null;

        if (is_string($child) || is_int($child) || is_null($child) || is_bool($child)) { // simple child
            return $child;
        } else if (is_array($child)) { // array of 'something'
            foreach ($child AS $c) {
                $childrenHTML .= $this->childToHTML($c);
            }
        } else if (is_object($child) && $child instanceof Element) { // should be Element
            $childrenHTML .= $child->toHTML();
        } else {
            throw new \Exception('Children is unknown type: ' . gettype($child) . get_class($child));
        }

        return $childrenHTML;
    }

    /**
     *
     */
    protected function triggerPreBuildOnChildren()
    {
        foreach ($this->children AS $child) {
            if ($child instanceof Element) {
                triggerEvent('htmlbuilder.predecorate', ['context' => $child->createContext()]);

                $child->triggerPreBuildOnChildren();
            }
        }
    }

    /**
     * @return null|string
     */
    public function toHTML()
    {
        if ($this->html) {
            return $this->html;
        }

        $listened = false;
        if (!dispatcher()->hasListeners('htmlbuilder.decorate')) {
            registerEvent(new DecorationRequested());
            registerEvent(new PreDecorationRequested());

            triggerEvent('htmlbuilder.predecorate', ['context' => $this->createContext()]);

            $this->triggerPreBuildOnChildren();

            triggerEvent('htmlbuilder.decorate', ['context' => $this->createContext()]);
            $listened = true;
        }

        // store html so it doesnt get executed again
        $this->html = $this->buildElement();

        if ($this->siblings) {
            $this->html .= $this->buildFromArray($this->siblings);
        }

        if ($this->decoratedParent) {
            $this->html = $this->decoratedParent->addChild($this->html)->toHTML();
        }

        if ($listened) {
            dispatcher()->destroy('htmlbuilder.decorate');
            dispatcher()->destroy('htmlbuilder.predecorate');
        }

        return $this->html . "\n";
    }

}