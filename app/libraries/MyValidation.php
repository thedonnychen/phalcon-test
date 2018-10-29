<?php
namespace PhalconTest\Libraries;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Confirmation;

class MyValidation extends Validation
{
    public function initialize()
    {
        $this->add(
            [
                'name',
                'email',
                'password'
            ],
            new PresenceOf(
                [
                    'message' => [
                        'name'      => 'The name is required',
                        'email'     => 'The e-mail is required',
                        'password'  => 'The password is required'
                    ]
                ]
            )
        );

        $this->add(
            [
                'password'
            ],
            new Confirmation(
                [
                    'message' => [
                        'password'  => 'Password does not match confirmation',
                    ],
                    'with' => [
                        'password' => 'confirmPassword'
                    ]
                ]
            )
        );

        $this->add(
            'email',
            new Email(
                [
                    'message' => 'The e-mail is not valid',
                ]
            )
        );
    }

}

