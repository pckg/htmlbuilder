<?php namespace Pckg\Htmlbuilder\Snippet;

trait Placeholdered
{

    public function setPlaceholder($label)
    {
        $this->__call('setPlaceholder', [$label]);

        return $this;
    }

}