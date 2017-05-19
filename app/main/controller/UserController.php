<?php

namespace controller;

use model\User;
use service\UserManager;

class UserController extends AbstractController
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            $loginUser = new User();
            $loginUser->load();
            $user = UserManager::login($loginUser);
            if (empty($user)) {
                $this->render('user/login', ['error' => "User not found"]);
            } else {
                $this->response->redirect('/');
            }
        } else {
            $this->render('user/login');
        }
    }

    public function logoutAction()
    {
        UserManager::logout();
        $this->response->redirect('/');
    }
}
