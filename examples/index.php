<?php

use Pckg\Htmlbuilder\Examples\Allaround;
use Pckg\Htmlbuilder\Examples\ForgotPassword;
use Pckg\Htmlbuilder\Examples\Login;
use Pckg\Htmlbuilder\Examples\Register;
use Pckg\Htmlbuilder\Examples\Multiple;

$forms = [
    'Login' => Login::class,
    'ForgotPassword' => ForgotPassword::class,
    'Register' => Register::class,
    'Multiple' => Multiple::class,
    'Allaround' => Allaround::class,
];

$content = '';
foreach ($forms AS $file => $class) {
    include_once 'basic/' . $file . '.php';
    $formObject = new $class;
    $formObject->init();

    /*
     * $formObject->bootstrap(); // adds bootstrap decorators
     * $formObject->angularJS();
     *
     * */

    $content .= '<div class="col-md-12"><br style="clear: both;" /><br style="clear: both;" /><br style="clear: both;" />' . get_class($formObject);
    $content .= $formObject->toHTML();
    $content .= "</div>";
}

return ($content);