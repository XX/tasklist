<?php

namespace model;

use Application;
use util\FileHelper;
use util\RequestHelper;

class User extends AbstractEntity
{
    public $username;
    public $password;
    public $role;

    public function load()
    {
        $data = RequestHelper::postData([
            'username' => FILTER_DEFAULT
        ]);
        $this->username = $data['username'];
        $this->password = RequestHelper::getRawPostValue('password');
    }
}