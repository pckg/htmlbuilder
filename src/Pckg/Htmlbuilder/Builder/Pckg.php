<?php

namespace Pckg\Htmlbuilder\Builder;

use Pckg\Htmlbuilder\Element\Select;

class Pckg extends Classic
{

    /**
     * @return string
     */
    public function buildBeforeElement()
    {
        if ($this->element instanceof Select) {
            return '<pckg-select' . $this->element->buildAttributes() . '>';
        }

        $tag = $this->element->getTag();

        return "<" . $tag . $this->element->buildAttributes() .
               ($this->element->isSelfClosing()
                   ? " />"
                   : ">");
    }

    public function buildChildrenElements()
    {
        if ($this->element instanceof Select) {
            return '';
        }

        return parent::buildChildrenElements();
    }

    public function buildAfterElement()
    {
        if ($this->element instanceof Select) {
            return '</pckg-select>';
        }

        return parent::buildAfterElement(); // TODO: Change the autogenerated stub
    }
}
