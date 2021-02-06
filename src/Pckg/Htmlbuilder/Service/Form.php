<?php

namespace Pckg\Htmlbuilder\Service;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Form extends Bootstrap
{

    public function create()
    {
        return new static();
    }
}
