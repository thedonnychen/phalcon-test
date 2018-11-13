<?php
namespace Eaty\Models;

use Phalcon\Mvc\Model;

class Users extends Model
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;

    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getPassword() {
        return $this->password;
    }
}