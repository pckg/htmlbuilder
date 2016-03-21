<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Framework\Inter\Entity\Languages;
use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Allaround extends Bootstrap
{

    public function init()
    {
        $form = $this;

        $form->addStep('registration');

        $email = $form->addEmail('email')// adds email validation ...
        ->setLabel('Email')
            ->required(); // require it

        $username = $form->addText('username')// add field for username
        ->setLabel('Username')
            //->unique() // make it unique, because record will do all the work
            //    ->min(3) // != above(3) // min length is 3 chars
            //    ->below(20) // != max(20) // shorter than 20
        ;//    ->requireText(); // onla a-ZA-z0-9, .,-!?*-+.... is allowed


        $password = $form->addPassword('password')
            ->setLabel('Password');//    ->requirePassword(); // min 8 by default

        $repeatPassword = $form->addPassword('password_repeat')
            ->setLabel('Repeat password');//    ->matchesField('password');

        $form->addButton('next'); // add button for next step

        $form->addStep('basic_info');

// create select and automatically prefill it with user groups
        $select = $form->addSelect('user_group_id')
            ->setLabel('User group')
            ->required();

        $select = $form->addSelect('friends')
            ->setLabel('Friends')/*->max(100)*/
        ; // w00t! allows select max 100 friends through mtm relation =)


        $slug = $form->addText('slug')
            ->setLabel('slug')
            //->unique()
            //    ->min(3)
        ;//    ->requireAlphanumeric();

        $form->addStep('random_info'); // button 'next' was automatically added because it was missing

        $powerOfTwo = $form->addNumber('power_of_two')
            ->setLabel('Your favourite power of 2 =)')/*->addValidator(/* new Validator/PowerOf(2) * /)*/
        ; // automatically adds php and js validator ;-)

        $birthdate = $form->addDate('date')
            ->setLabel('Date')//    ->requireMin(date('Y-m-d', strtotime('100 years')))
        ;//    ->requireMax(date('Y-m-d', strtotime('-16 years')));

        $gender = $form->addRadioGroup('gender')
            ->setLabel('Gender'); // user record has relation with gender 'shifrant' and it magically fills it :P

        $gender->addOption('m', 'Male');
        $gender->addOption('f', 'Female');

        $country = $form->addSelect('country_id')// ... relation with countries
        ->setLabel('Country')
            ->required()/*->autocomplete()*/
        ; // enables autocomplete, sirjusli =)

        $language = $form->addSelect('language_id')
            ->setValue(2)
            ->useEntityDatasource(new Languages())
            ->setLabel('Language')
            ->required()/*->default('en')*/
        ;

        $randomTime = $form->addTime('time')
            ->setLabel('Time')
            ->setValue(date('H:i'))
            ->required(); // just require it =)

        $dtRegistered = $form->addDatetime('dt_registered')
            ->setLabel('Dt registered')/*->disabled()*/
        ; // dont allow change and don't change anything

        $isEnabled = $form->addCheckbox('enabled')
            ->setLabel('Enabled');

        $tos = $form->addCheckbox('tos')
            ->setLabel('I agree with TOS')
            ->required();

        $avatar = $form->addPicture('avatar')
            ->setLabel('Avatar'); // don't require it, automatically allow only picture filetypes

        $cv = $form->addFile('cv')
            ->setLabel('CV')/*->allowFileExtensions(['doc', 'docx', 'pdf'])*/
        ;

        $form->addStep('foobar');

        /*$lastIp = $form->addIP('ip')
            ->requireIPv4();*/ // this is just sick

//$someHtml = $form->addHtml('','Field below will be available when you enter IP');

        $description = $form->addEditor('description')
            ->setLabel('Description')/*->enableOnValid('ip')*/
        ; // when ip is valid we allow description editing

        $btnSubmit = $form->addSubmit('submit'); // 'Submit' button

        $btnCancel = $form->addCancel('reset', 'Just cancel it'); // reset button with 'Just cancel it'


        return $this;
    }

}