<?php namespace Pckg\Htmlbuilder\Resolver;

use Pckg\Concept\Reflect;
use Pckg\Concept\Reflect\Resolver;
use Pckg\Framework\Request;
use Pckg\Framework\Request\Data\Flash;
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
     * @var Flash
     */
    protected $flash;

    /**
     * @var Form
     */
    protected $form;

    public function canResolve($class)
    {
        return class_exists($class) && is_subclass_of($class, Form::class);
    }

    public function resolve($form)
    {
        if (is_subclass_of($form, Form::class)) {
            $this->form = Reflect::create($form);
            $this->request = context()->getOrCreate(Request::class);

            if (object_implements($form, ResolvesOnRequest::class)) {
                if ($this->request->isPost()) {
                    $this->response = context()->getOrCreate(Response::class);
                    $this->flash = context()->getOrCreate(Flash::class);

                    return $this->resolvePost();
                } elseif ($this->request->isGet()) {
                    return $this->resolveGet();
                }
            }

            return $this->form;
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
        if ($this->form->isValid($errors)) {
            return $this->form;
        } else {
            /**
             * Fill session with form data.
             */
            $this->form->populateToSession();

            if ($this->request->isAjax()) {
                return $this->ajaxErrorResponse($errors);
            } else {
                return $this->postErrorResponse();
            }
        }
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
        $this->flash->set('form', 'Form submitted successfully');

        return $this->form;
    }

    /**
     * Respond with code 200, return json data.
     */
    protected function ajaxSuccessResponse()
    {
        return $this->response->code(200)
                              ->respond([
                                            'success' => true,
                                            'error'   => false,
                                        ]);
    }

    /**
     * Respond with code 422, return json data.
     */
    protected function ajaxErrorResponse($errors = ['@T00D002'])
    {
        return $this->response->code(422)
                              ->respond([
                                            'error'   => true,
                                            'success' => false,
                                            'errors'  => $errors,
                                        ]);
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