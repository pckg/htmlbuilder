<?php

$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that frontpage works');
$I->amOnPage('/dev.php/dynamic/tables/7/edit/6');
$I->see('Title');
$I->click('submit');

?>