<?php

namespace util;

class RequestHelper
{
    public static function get($key, $filter = FILTER_DEFAULT, $options = [])
    {
        if (isset($_GET[$key])) {
            return filter_var($_GET[$key], $filter, $options);
        }
        return null;
    }

    public static function postData($filter)
    {
        return filter_var_array($_POST, $filter);
    }

    public static function getRawGetValue($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : null;
    }

    public static function getRawPostValue($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : null;
    }
}