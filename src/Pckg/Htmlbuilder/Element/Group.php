<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Group
 *
 * @package Pckg\Htmlbuilder\Element
 */
class Group extends Element
{

    use Labeled;

    /**
     * @var string
     */
    protected $tag = 'div';

    /**
     * @var array
     */
    protected $classes = ['group'];

}