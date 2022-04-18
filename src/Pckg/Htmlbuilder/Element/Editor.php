<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Editor
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Editor extends Textarea
{
    public function __construct()
    {
        parent::__construct();

        $this->addClass('editor');
    }
}
