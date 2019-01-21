<?php namespace Pckg\Htmlbuilder\Provider;

use Pckg\Framework\Provider;
use Pckg\Htmlbuilder\Service\Form;

class Htmlbuilder extends Provider
{

    public function viewObjects()
    {
        return [
            '_formService' => function() {
                return new Form();
            },
        ];
    }

}