<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element\Input;

/**
 * Class File
 * @package Pckg\Htmlbuilder\Element\Input
 */
class File extends Input
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("file");
    }
}