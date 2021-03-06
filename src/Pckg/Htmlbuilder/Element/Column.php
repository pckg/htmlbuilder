<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Snippet\Buildable;
use Pckg\Htmlbuilder\Snippet\Labeled;

class Column extends Div
{
    use Buildable;
    use Labeled;

    protected $classes = ['form-column'];
}
