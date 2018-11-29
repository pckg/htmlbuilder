<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Field
 *
 * @package Pckg\Htmlbuilder\Element
 * @method $this required
 * @method $this addValidator
 */
class Field extends Element
{

    use Labeled;

    protected $tag = 'div';

}