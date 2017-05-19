<?php

namespace controller;

use Application;
use service\UserManager;
use util\ViewHelper;

abstract class AbstractController
{
    protected $request;
    protected $response;
    
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected function render($view, $data = [], $direct = false)
    {
        $viewDir = Application::$config['viewDir'];
        $content = $viewDir . $view . '.php';
        $topView = $direct ? $content : $viewDir . 'layout.php';
        $data = ViewHelper::sanitize($data);
        $user = UserManager::getUser();

        ob_start();
        include($topView);
        $this->response->body(ob_get_clean());
    }
}
