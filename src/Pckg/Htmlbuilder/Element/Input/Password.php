<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Password
 * @package Pckg\Htmlbuilder\Element\Input
 */
class Password extends Input
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();

        $this->setType("password");

        $this->setAttribute('autocomplete', 'off');
    }

    /**
     * @param Element $element
     */
    function transferFromElement(Element $element)
    {
        parent::transferFromElement($element);

        if (($form = $this->closest('form'))) {
            $form->setAttribute('autocomplete', 'off');
        }
    }
}