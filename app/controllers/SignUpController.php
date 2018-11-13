<?php

use Phalcon\Mvc\Controller,
    Phalcon\Http\Request,
    Eaty\Forms\UserSignUpForm,
    Eaty\Models\Users;
    
class SignupController extends Controller
{
    public $users;

    public function initialize()
    {
        $this->users = new Users();
    }

    public function indexAction()
    {
        $this->view->form = new UserSignUpForm();
    }

    public function submitAction()
    {
        $form = new UserSignUpForm();

        if (!$this->request->isPost()) {
            return $this->response->redirect('/phalcon-test/signup');
        }

        $form->bind($_POST, $this->users);
        
        $this->users->setPassword($this->security->hash($_POST['password']));

        if (!$form->isValid()) {
            foreach ($form->getMessages() as $message) {

                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'index',
                ]);
                return;
            }
        }

        if (!$this->users->save()) {
            foreach ($this->users->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'index',
                ]);
                return;
            }
        }

        $this->flashSession->success('Thanks for registering!');
        return $this->response->redirect('/phalcon-test/signup');

        $this->view->disable();
    }
}