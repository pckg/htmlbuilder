<?php namespace Pckg\Htmlbuilder\Builder;

use Pckg\Htmlbuilder\Element\Editor;

class Pckg extends Classic
{

    /**
     * @return string
     */
    public function buildBeforeElement()
    {
        $mapper = [
            Editor::class => 'pckg-editor',
        ];

        $tag = $this->element->getTag();

        return "<" . $tag . $this->element->buildAttributes() .
               ($this->element->isSelfClosing()
                   ? " />"
                   : ">");
    }

}