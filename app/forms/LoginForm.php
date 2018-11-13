<?php
namespace Eaty\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Confirmation,
    Phalcon\Validation\Validator\Email;

class LoginForm extends Form
{
    public function initialize()
    {
        $email = new Text('email', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Email Address"
        ]);

        $email->addValidators([
            new PresenceOf(['message' => 'The email is required']),
            new Email(['message' => 'The email is not valid']),
        ]);

        $password = new Password('password', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Password"
        ]);
        
        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
        ]);

        $submit = new Submit('submit', [
            "value" => "Login",
            "class" => "btn btn-primary",
        ]);

        $this->add($email);
        $this->add($password);
        $this->add($submit);
    }
}