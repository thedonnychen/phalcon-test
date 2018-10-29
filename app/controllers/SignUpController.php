<?php

use Phalcon\Mvc\Controller;
use PhalconTest\Libraries\MyValidation;

class SignupController extends Controller
{
    public function indexAction()
    {
        $this->assets->addCss('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
        $this->assets->addJs('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js');
    }

    public function registerAction()
    {
        $user = new Users();
        $validation = new MyValidation();

        if (!$this->request->isPost()) {
            return $this->response->redirect('user/register');
        }

        $user->setPassword($this->security->hash($_POST['password']));
        
        // Store and check for errors
        $success = $user->save(
            $this->request->getPost(),
            [
                "name",
                "email",
                "password"
            ]
        );

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";

            $messages = $validation->validate($_POST);

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }
        
        $this->view->disable();
    }
}