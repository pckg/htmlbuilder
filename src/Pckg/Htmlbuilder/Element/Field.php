<?php

namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Labeled;

/**
 * Class Field
 *
 * @package Pckg\Htmlbuilder\Element
 * @method $this required()
 * @method $this addValidator($validator)
 */
class Field extends Element
{
    use Labeled;

    protected $tag = 'div';

    protected $defaultValue = null;

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
