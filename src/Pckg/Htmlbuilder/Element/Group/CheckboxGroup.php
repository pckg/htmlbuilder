<?php

namespace Pckg\Htmlbuilder\Element\Group;

use Pckg\Htmlbuilder\Element\Group;
use Pckg\Htmlbuilder\Snippet\Buildable\Checkboxable;

/**
 * Class CheckboxGroup
 *
 * @package Pckg\Htmlbuilder\Element\Group
 */
class CheckboxGroup extends Group
{

    use Checkboxable;

    /**
     * @var array
     */
    protected $classes = ['row', 'group', 'checkbox-group'];

}