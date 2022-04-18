<?php

namespace Pckg\Htmlbuilder\Validator\Method;

use Pckg\Htmlbuilder\Validator\AbstractGroupValidator;

/**
 * Class Common
 *
 * @package Pckg\Htmlbuilder\Validator\Method
 */
class Common extends AbstractGroupValidator
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->validators = $this->validatorFactory->create(
            [
                'Common\Required',
                'Common\Unique',
                'Common\Matches',
            ]
        );

        $this->initOverloadMethods();
    }
}
