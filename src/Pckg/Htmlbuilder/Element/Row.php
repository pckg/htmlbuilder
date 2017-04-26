<?php namespace Pckg\Htmlbuilder\Element;

use Pckg\Htmlbuilder\Snippet\Buildable;

class Row extends Div
{

    use Buildable;

    protected $classes = ['row'];

}