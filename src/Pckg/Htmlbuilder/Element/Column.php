<?php namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Snippet\Buildable;

class Column extends Div
{

    use Buildable;

    protected $classes = ['form-column'];

}