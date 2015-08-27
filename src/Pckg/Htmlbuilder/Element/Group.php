<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;

/**
 * Class Group
 * @package Pckg\Htmlbuilder\Element
 */
class Group extends Element
{

    /**
     * @var string
     */
    protected $tag = 'div';

    /**
     * @var array
     */
    protected $classes = ['group'];

}