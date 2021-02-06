<?php

namespace Pckg\Htmlbuilder\Builder;

use Pckg\Htmlbuilder\Element;

class Classic extends AbstractBuilder
{

    public function build(Element $element = null)
    {
        $this->element = $element;

        return ($this->element->isOpened() ? '' : $this->buildBeforeElement()) . $this->buildChildrenElements() .
               $this->buildAfterElement();
    }

    /**
     * @return string
     */
    public function buildBeforeElement()
    {
        return "<" . $this->element->getTag() . $this->element->buildAttributes() .
               ($this->element->isSelfClosing()
                   ? " />"
                   : ">");
    }

    /**
     * @return string
     */
    public function buildChildrenElements()
    {
        return $this->element->isSelfClosing()
            ? ''
            : $this->element->buildFromArray($this->element->getChildren());
    }

    /**
     * @return string
     */
    public function buildAfterElement()
    {
        return $this->element->isSelfClosing()
            ? ''
            : ("</" . $this->element->getTag() . ">");
    }
}
