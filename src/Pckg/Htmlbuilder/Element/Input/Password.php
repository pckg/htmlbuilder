<?php

namespace Pckg\Htmlbuilder\Element\Input;

use Pckg\Htmlbuilder\Element;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\Element\Input;

/**
 * Class Password
 *
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
    }

    /**
     * @param Element $element
     */
    function transferFromElement(Element $element)
    {
        parent::transferFromElement($element);

        $topParent = $this->getTopParent();
        if (($form = $this->closest('form'))) {
            $form->setAttribute('autocomplete', 'off');
        } elseif ($topParent instanceof Form) {
            $topParent->setAttribute('autocomplete', 'off');
        }
    }
}