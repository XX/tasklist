<?php

namespace service;

use model\User;

class UserManager
{
    public static function login($loginUser)
    {
        $user = User::findOne(['username' => $loginUser->username]);
        if (!empty($user) && password_verify($loginUser->password, $user->password)) {
            $_SESSION['user'] = $user;
            return $user;
        }
        return null;
    }

    public static function logout()
    {
        unset($_SESSION['user']);
    }

    public static function isGuest()
    {
        return empty($_SESSION['user']);
    }

    public static function getUser()
    {
        return empty($_SESSION['user']) ? null : $_SESSION['user'];
    }

    public static function hasRole($role)
    {
        $user = self::getUser();
        if (!empty($user)) {
            return $user->role === $role;
        }
        return false;
    }
}