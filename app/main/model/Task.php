<?php

namespace model;

use Application;
use util\FileHelper;
use util\RequestHelper;

class Task extends AbstractEntity
{
    public $username;
    public $email;
    public $description;
    public $image_uri;
    public $status;

    public function load()
    {
        $data = RequestHelper::postData([
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'username' => FILTER_DEFAULT,
            'email' => FILTER_SANITIZE_EMAIL,
            'description' => FILTER_DEFAULT,
        ]);
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->description = $data['description'];

        $status = RequestHelper::getRawPostValue('status');
        $this->status = $status === 'done' ? $status : 'new';

        $imagePath = FileHelper::uploadAndGetImageFile();
        if (!empty($imagePath)) {
            $this->image_uri = Application::$config['uploadUri'] . pathinfo($imagePath, PATHINFO_BASENAME);
        }
    }
}