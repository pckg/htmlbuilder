<?php

namespace Pckg\Htmlbuilder\Element\Group;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Snippet\Buildable\Radioable;

/**
 * Class RadioGroup
 *
 * @package Pckg\Htmlbuilder\Element\Group
 */
class RadioGroup extends Element\Group
{

    use Radioable;

    /**
     * @var array
     */
    protected $classes = ['row', 'group', 'radio-group'];

}