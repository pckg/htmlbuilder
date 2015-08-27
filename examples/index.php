<?php

return;

$forms = [
    'Login',
    'ForgotPassword',
    'Register',
    'Multiple',
    'Allaround',
];

$content = '';
foreach ($forms AS $form) {
    $file = $form;
    $class = 'Pckg\Htmlbuilder\Examples\\' . $form;

    include_once 'basic/' . $file . '.php';
    $formObject = new $class;
    $formObject->init();

    /*
     * $formObject->bootstrap(); // adds bootstrap decorators
     * $formObject->angularJS();
     *
     * */

    $content .= '<div class="col-md-12"><br style="clear: both;" /><br style="clear: both;" /><br style="clear: both;" />';
    $content .= $formObject->toHTML();
    $content .= "</div>";
}

return ($content);