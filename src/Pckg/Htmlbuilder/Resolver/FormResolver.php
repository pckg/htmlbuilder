<?php namespace Pckg\Htmlbuilder\Resolver;

use Pckg\Concept\Reflect;
use Pckg\Concept\Reflect\Resolver;
use Pckg\Framework\Request;
use Pckg\Framework\Request\Data\Flash;
use Pckg\Framework\Response;
use Pckg\Htmlbuilder\Element\Form;

class FormResolver implements Resolver
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var Flash
     */
    protected $flash;

    /**
     * @var Form
     */
    protected $form;

    public function resolve($form)
    {
        if (is_subclass_of($form, Form::class)) {
            $this->request = context()->getOrCreate('Request', Request::class);

            if ($this->request->isPost()) {
                $this->response = context()->getOrCreate('Response', Response::class);
                $this->flash = context()->getOrCreate('Flash', Flash::class);

                return $this->resolvePost($form);
            } elseif ($this->request->isGet()) {
                return $this->resolveGet($form);
            }
        }
    }

    protected function resolvePost($form)
    {
        $this->resolveGet($form);

        if ($this->form->isValid()) {
            if ($this->request->isAjax()) {
                return $this->ajaxSuccessResponse();

            } else {
                return $this->postSuccessResponse();

            }
        } else {
            if ($this->request->isAjax()) {
                return $this->ajaxErrorResponse();

            } else {
                return $this->postErrorResponse();

            }
        }
    }

    public function resolveGet($form)
    {
        $this->form = Reflect::create($form);
        $this->form->initFields();

        return $this->form;
    }

    /**
     * Return resolved form (valid ;-)).
     */
    protected function postSuccessResponse()
    {
        $this->flash->set('form', 'Form submitted successfully');

        return $this->form;
    }

    /**
     * Respond with code 200, return json data.
     */
    protected function ajaxSuccessResponse()
    {
        return $this->response->code(200)
            ->respond(json_encode([
                'success' => true,
                'error'   => false,
            ]));
    }

    /**
     * Respond with code 422, return json data.
     */
    protected function ajaxErrorResponse()
    {
        return $this->response->code(422)
            ->respond(json_encode([
                'error'   => true,
                'success' => false,
                'errors'  => ['@T00D00'],
            ]));
    }

    /**
     * Respond with code 400, redirect to get action
     */
    protected function postErrorResponse()
    {
        $this->flash->set('form', 'Invalid data posted, check data and resubmit form');

        return $this->response->code(400)
            ->redirect();
    }

}