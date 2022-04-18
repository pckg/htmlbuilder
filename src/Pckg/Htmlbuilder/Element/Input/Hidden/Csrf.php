<?php

namespace Pckg\Htmlbuilder\Element\Input\Hidden;

use Pckg\Htmlbuilder\Element\Input\Hidden;

/**
 * Class Csrf
 *
 * @package Pckg\Htmlbuilder\Element\Input\Hidden
 */
class Csrf extends Hidden
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->setName('_csrf');
        $this->setValue(sha1(microtime() . rand(0, 1024 * 1024 * 1024) . md5(microtime())));
    }
}
