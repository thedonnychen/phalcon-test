<?php

use Phalcon\Mvc\Controller,
    Eaty\Forms\UserEditForm,
    Eaty\Models\Users;

class AccountController extends Controller
{
    public $user;

    public function initialize()
    {
        $this->users = new Users();
    }

    public function indexAction()
    {
    }

    public function editAction()
    {   
        $user               = Users::findFirst($this->session->get('user_id'));
        $this->view->form   = new UserEditForm($user, 
            [
                'edit' => true
            ]
        );
    }

    public function editSubmitAction()
    {
        $form   = new UserEditForm();
        $data   = $this->request->getPost();
        $user   = Users::findFirstById($this->session->get('user_id'));

        if (!$this->request->isPost()) {
            return $this->response->redirect('/phalcon-test/account');
        }

        $user->setPassword($this->security->hash($_POST['edit_password']));

        if (!$form->isValid($data, $user)) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        if ($user->save()) {
            foreach ($this->users->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'edit',
                ]);
                return;
            }
        }

        $this->flashSession->success('Account was successfully updated.');
        return $this->response->redirect('phalcon-test/account/');

        $this->view->disable();
    }
}