<?php namespace Pckg\Htmlbuilder\Snippet;

trait Labeled
{

    public function setLabel($label)
    {
        $this->__call('setLabel', [$label]);

        return $this;
    }

    public function setHelp($help)
    {
        $this->__call('setHelp', [$help]);

        return $this;
    }

}