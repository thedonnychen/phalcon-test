<?php

use Phalcon\Mvc\Controller,
    Eaty\Forms\LoginForm,
    Eaty\Models\Users;

class LoginController extends Controller
{
    public $users;

    public function initialize()
    {
        $this->users = new Users();
    }

    public function indexAction()
    {
        $this->view->form = new LoginForm();
    }

    public function submitAction()
    {
        $form = new LoginForm();

        if (!$this->request->isPost()) {
            return $this->response->redirect('phalcon-test/login');
        }

        $form->bind($_POST, $this->users);
        
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

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = Users::findFirst([ 
            'email = :email:',
            'bind' => [
               'email' => $email,
            ]
        ]);

        if ($user) {
            if ($this->security->checkHash($password, $user->password)) {
                 $this->flashSession->success("Login Success");
                return $this->response->redirect('phalcon-test/login');
            }
        }

        $this->flashSession->error("Invalid login");
        return $this->response->redirect('phalcon-test/login');
    }
}