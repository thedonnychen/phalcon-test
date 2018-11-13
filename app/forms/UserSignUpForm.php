<?php
namespace Eaty\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Confirmation,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Uniqueness,
    Eaty\Models\Users;

class UserSignUpForm extends Form
{   
    public function initialize()
    {
        $first_name = new Text('first_name', [
            "class"       => "form-control",
            "required"    => true,
            "placeholder" => "Enter First Name"
        ]);

        $first_name->addValidator(
            new PresenceOf(['message' => 'Your first name is required'])
        );

        $last_name = new Text('last_name', [
            "class"       => "form-control",
            "required"    => true,
            "placeholder" => "Enter Last Name"
        ]);

        $last_name->addValidator(
            new PresenceOf(['message' => 'Your last name is required'])
        );

        $email = new Text('email', [
            "class"       => "form-control",
            "required"    => true,
            "placeholder" => "Enter Email Address"
        ]);

        $email->addValidators([
            new PresenceOf(['message' => 'The email is required']),
            new Uniqueness([
                'model'    => new Users(),
                'message'  => 'This email has already been registered',
            ]),
            new Email(['message' => 'The email is not valid']),
        ]);

        $password = new Password('password', [
            "class"       => "form-control",
            "required"    => true,
            "placeholder" => "Your Password"
        ]);

        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
            new Confirmation(['with' => 'password_confirm', 'message' => 'Password doesn\'t match confirmation.']),
        ]);

        $passwordConfirm = new Password('password_confirm', [
            "class"       => "form-control",
            "required"    => true,
            "placeholder" => "Confirm Password"
        ]);

        $passwordConfirm->addValidators([
            new PresenceOf(['message' => 'The confirmation password is required']),
        ]);

        $submit = new Submit('submit', [
            "value" => "Register",
            "class" => "btn btn-primary",
        ]);

        $this->add($first_name);
        $this->add($last_name);
        $this->add($email);
        $this->add($password);
        $this->add($passwordConfirm);
        $this->add($submit);
    }
}