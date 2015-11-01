<?php

namespace Pckg\Htmlbuilder\Examples;

use Pckg\Htmlbuilder\Element\Form\Bootstrap;

class Multiple extends Bootstrap
{

    public function init()
    {
        $form = $this;

        $attributes = $form->addFieldset('address');

        $attributes->addHidden('id');
        $attributes->addSelect('title_id')->setLabel('Title')->required();
        $attributes->addText('name')->setLabel('Name')->required();
        $attributes->addText('surname')->setLabel('Surname');
        $attributes->addSelect('country')->setLabel('Country')->required();

        // on this stage this is form with 3 fields

        // now we automatically copy fieldset multiple times and transform surname to surname[1], surname[2] ...
        // $addresses = entity('UserAddresses')->where('user_id', 1)->all();
        // $attributes->useCollectionDatasource($addresses);

        // because we want user to be able to add address, we enable it =)
        // this will create new fieldset with default record from collection
        // ... and 'add' button which will trigger duplication
        // $attributes->addable();

        // we also want user to be able to delete address
        // this adds delete button to each row
        // $attributes->deletable();

        // what the hell, we'll allow user to add 3 addresses
        // $attributes->max(3);

        // $attributes->useRecordDatasource($userAddress);

        $form->addSubmit('submit');
        $form->addCancel('reset', 'Just cancel it');

        return $this;
    }

}