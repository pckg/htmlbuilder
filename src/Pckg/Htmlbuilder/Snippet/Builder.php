<?php

namespace Pckg\Htmlbuilder\Snippet;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Event\DecorationRequested;
use Pckg\Htmlbuilder\Event\PopulationRequested;
use Pckg\Htmlbuilder\Event\PreDecorationRequested;
use Pckg\Htmlbuilder\Event\PrePopulationRequested;

/**
 * Class Builder
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
     * @return string
     */
    public function __toString()
    {
        // i think this needs to be this way because twig somehow calls __toString (renderBlock, displayBlock)
        if (!$this->html) {
            try {
                $this->toHTML();
            } catch (\Exception $e) {
                return '<!-- ' . $e->getMessage() . $e->getFile() . '-->';
            }
        }

        return (string)$this->html;
    }

    /*
    Builds simple html
    */
    /**
     * @return string
     */
    public function buildElement()
    {
        return ($this->opened ? '' : $this->buildBeforeElement()) . $this->buildChildrenElements() . $this->buildAfterElement();
    }

    /**
     * @return string
     */
    private function buildBeforeElement()
    {
        return "<" . $this->tag . $this->buildAttributes() .
        ($this->selfClosing
            ? " />"
            : ">");
    }

    /**
     * @return string
     */
    private function buildChildrenElements()
    {
        return $this->selfClosing
            ? ''
            : $this->buildFromArray($this->children);
    }

    /**
     * @return string
     */
    private function buildAfterElement()
    {
        return $this->selfClosing
            ? ''
            : ("</" . $this->tag . ">");
    }

    public function open()
    {
        $this->opened = true;

        return $this->buildBeforeElement();
    }

    public function close()
    {
        return $this->buildAfterElement();
    }

    /*
    Builds childrens
    */
    /**
     * @param $siblings
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
     *
     */
    protected function triggerPrePopulateOnChildren()
    {
        foreach ($this->children AS $child) {
            if ($child instanceof Element) {
                triggerEvent('htmlbuilder.prepopulate', ['context' => $child->createContext()]);

                $child->triggerPrePopulateOnChildren();
            }
        }
    }

    /**
     *
     */
    protected function triggerPopulateOnChildren()
    {
        foreach ($this->children AS $child) {
            if ($child instanceof Element) {
                triggerEvent('htmlbuilder.populate', ['context' => $child->createContext()]);

                $child->triggerPopulateOnChildren();
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

    public function populateToDatasource()
    {
        $listened = false;
        if (!dispatcher()->hasListeners('htmlbuilder.populate')) {
            registerEvent(new PopulationRequested());
            registerEvent(new PrePopulationRequested());

            triggerEvent('htmlbuilder.prepopulate', ['context' => $this->createContext()]);

            $this->triggerPrePopulateOnChildren();

            triggerEvent('htmlbuilder.populate', ['context' => $this->createContext()]);

            $this->triggerPopulateOnChildren();
            $listened = true;
        }

        if ($this->decoratedParent) {
            $this->decoratedParent->populate();
        }

        if ($listened) {
            dispatcher()->destroy('htmlbuilder.populate');
            dispatcher()->destroy('htmlbuilder.prepopulate');
        }

        return $this;
    }

}