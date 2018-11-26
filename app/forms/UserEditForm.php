<?php
namespace Eaty\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Confirmation,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Uniqueness,
    Eaty\Models\Users;

class UserEditForm extends Form
{
    public function initialize()
    {
        $first_name = new Text('first_name', [
            "class"       => "form-control",
            "placeholder" => "Enter First Name"
        ]);

        $last_name = new Text('last_name', [
            "class"       => "form-control",
            "placeholder" => "Enter Last Name"
        ]);

        $email = new Text('email', [
            "class"       => "form-control",
            "placeholder" => "Enter Email Address"
        ]);

        $email->addValidators([
            new Uniqueness([
                'model'         => new Users(),
                'message'       => 'This email has already been registered',
                'allowEmpty'    => true,
            ]),
            
            new Email([
                'message'       => 'The email is not valid',
                'allowEmpty'    => true,
            ]),
        ]);

        $password = new Password('edit_password', [
            "class"       => "form-control",
            "placeholder" => "Your Password",
        ]);

        $password->addValidators([
            new StringLength([
                'min'           => 5, 
                'message'       => 'Password is too short. Minimum 5 characters.',
                'allowEmpty'    => true,
            ]),

            new Confirmation([
                'with'          => 'edit_password_confirm', 
                'message'       => 'Password doesn\'t match confirmation.',
                'allowEmpty'    => true,
            ]),
        ]);

        $passwordConfirm = new Password('edit_password_confirm', [
            "class"       => "form-control",
            "placeholder" => "Confirm Password"
        ]);

        $submit = new Submit('submit', [
            "value" => "Save",
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