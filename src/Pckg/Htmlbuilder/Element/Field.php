<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Field
 *
 * @package Pckg\Htmlbuilder\Element
 * @method Pckg\Htmlbuilder\Element\Field required
 * @method Pckg\Htmlbuilder\Element\Field addValidator
 */
class Field extends Element
{

    use Labeled;

    protected $tag = 'div';

}