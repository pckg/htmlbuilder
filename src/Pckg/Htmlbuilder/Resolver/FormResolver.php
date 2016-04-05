<?php namespace Pckg\Htmlbuilder\Resolver;

use Pckg\Concept\Reflect;
use Pckg\Concept\Reflect\Resolver;
use Pckg\Framework\Request;
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
     * @var Form
     */
    protected $form;

    public function resolve($form)
    {
        if (is_subclass_of($form, Form::class)) {
            $this->request = Reflect::create(Request::class);

            if ($this->request->isPost()) {
                $this->response = Reflect::create(Response::class);

                return $this->resolvePost($form);
            }
        }
    }

    protected function resolvePost($form)
    {
        $this->form = Reflect::create($form);

        if ($this->form->isValid() && false) {
            if ($this->request->isAjax()) {
                return $this->ajaxErrorResponse();

            } else {
                return $this->postErrorResponse();

            }
        } else {
            if ($this->request->isAjax()) {
                return $this->ajaxErrorResponse();

            } else {
                return $this->postErrorResponse();

            }
        }
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
        return $this->response->code(400)
            ->redirect();
    }

    /**
     * Return resolved form (valid ;-)).
     */
    protected function postSuccessResponse()
    {
        return $this->form;
    }

}