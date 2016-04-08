<?php namespace Pckg\Htmlbuilder\Snippet;

trait Labeled
{

    public function setLabel($label)
    {
        $this->__call('setLabel', [$label]);

        return $this;
    }

}