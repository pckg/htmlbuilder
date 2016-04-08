<?php namespace Pckg\Htmlbuilder\Datasource\Method;

use Mailchimp as MailchimpAPI;
use Pckg\Htmlbuilder\Datasource\AbstractDatasource;
use Pckg\Htmlbuilder\Datasource\DatasourceInterface;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\ElementObject;

class Mailchimp extends AbstractDatasource implements DatasourceInterface
{

    protected $apiKey;

    protected $listId;

    protected function initOverloadMethods()
    {
        $this->methods = ['setMailchimpApiKey', 'setMailchimpListId', 'useMailchimpDatasource', 'storeToMailchimp'];
    }

    public function overloadSetMailchimpApiKey(callable $next, ElementObject $context)
    {
        $this->apiKey = $context->getArg(0);

        return $next();
    }

    public function overloadSetMailchimpListId(callable $next, ElementObject $context)
    {
        $this->listId = $context->getArg(0);

        return $next();
    }

    public function overloadUseMailchimpDatasource(callable $next, ElementObject $context)
    {
        $this->enabled = true;

        return $next();
    }

    public function overloadStoreToMailchimp(callable $next, ElementObject $context)
    {
        $element = $context->getElement();

        $this->storeToMailchimp($element);

        return $next();
    }

    public function storeToMailchimp(Form $form)
    {
        $data = $form->getRawData();
        list($data['first_name'], $data['last_name']) = explode(' ', $data['name_surname'], 2);

        $mailchimp = new MailchimpAPI($this->apiKey, ['ssl_verifypeer' => false]);

        return $mailchimp->lists->subscribe($this->listId, ['email' => $data['email']], [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
        ], 'html', true, true, false, true);
    }

}