<?php namespace Pckg\Htmlbuilder\Resolver;

use Pckg\Concept\Reflect;
use Pckg\Concept\Reflect\Resolver;
use Pckg\Framework\Request;
use Pckg\Framework\Response;
use Pckg\Htmlbuilder\Element\Form;
use Pckg\Htmlbuilder\Element\Form\ResolvesOnRequest;

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

    public function canResolve($class)
    {
        return class_exists($class) && is_subclass_of($class, Form::class);
    }

    public function prepare()
    {
        $this->request = context()->getOrCreate(Request::class);

        return $this;
    }

    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }

    public function resolve($form)
    {
        if (!is_subclass_of($form, Form::class)) {
            return;
        }

        $this->setForm(Reflect::create($form));
        $this->prepare();

        $resolve = object_implements($form, ResolvesOnRequest::class);
        if (!$resolve) {
            return $this->form;
        }

        return $this->resolveRequest();
    }

    /**
     * @return mixed|Response
     * @throws \Exception
     */
    protected function getResponse()
    {
        if (!$this->response) {
            $this->response = context()->getOrCreate(Response::class);
        }

        return $this->response;
    }

    public function resolveRequest()
    {
        if ($this->request->isPost()) {
            return $this->resolvePost();
        }

        if ($this->request->isGet()) {
            return $this->resolveGet();
        }
    }

    protected function resolvePost()
    {
        /**
         * Initialize fields.
         */
        $this->form->initFields();

        /**
         * Fill form with request data.
         */
        $this->form->populateFromRequest();

        $errors = [];
        $descriptions = [];
        if ($this->form->isValid($errors, $descriptions)) {
            return $this->form;
        }

        /**
         * Fill session with form data.
         */
        $this->form->populateToSession();

        if ($this->request->isAjax() || $this->request->isJson()) {
            return $this->ajaxErrorResponse($errors, $descriptions);
        }

        return $this->postErrorResponse();
    }

    protected function resolveArray()
    {
        /**
         * Initialize fields.
         */
        $this->form->initFields();

        /**
         * Fill form with request data.
         */
        $this->form->populateFromRequest();

        $errors = [];
        $descriptions = [];
        if ($this->form->isValid($errors, $descriptions)) {
            return $this->form;
        }

        /**
         * Fill session with form data.
         */
        $this->form->populateToSession();

        if ($this->request->isAjax() || $this->request->isJson()) {
            return $this->ajaxErrorResponse($errors, $descriptions);
        }

        return $this->postErrorResponse();
    }

    public function resolveGet()
    {
        /**
         * Initialize fields.
         */
        $this->form->initFields();

        /**
         * Fill form with session data.
         */
        $this->form->populateFromSession();

        return $this->form;
    }

    /**
     * Return resolved form (valid ;-)).
     */
    protected function postSuccessResponse()
    {
        return $this->form;
    }

    /**
     * Respond with code 200, return json data.
     */
    protected function ajaxSuccessResponse()
    {
        $this->getResponse()->code(200)->respond([
                                                            'success' => true,
                                                            'error'   => false,
                                                        ]);

        return $this->form;
    }

    /**
     * Respond with code 422, return json data.
     */
    public function ajaxErrorResponse($errors = ['@T00D002'], $descriptions = [])
    {
        $this->getResponse()->code(422)->respond([
                                                            'error'        => true,
                                                            'success'      => false,
                                                            'errors'       => $errors,
                                                            'descriptions' => $descriptions,
                                                        ]);

        return $this->form;
    }

    /**
     * Respond with code 400, redirect to get action
     */
    public function postErrorResponse()
    {
        $this->getResponse()->code(400)->redirect();

        return $this->form;
    }

}