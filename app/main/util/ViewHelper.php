<?php

namespace util;

class ViewHelper
{
    public static function sanitize($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = static::sanitize($value);
            }
        } else if (is_object($data)) {
            $fields = get_object_vars($data);
            foreach ($fields as $field => $value) {
                $data->$field = static::sanitize($value);
            }
        } else {
            $data = nl2br(htmlspecialchars($data));
        }
        return $data;
    }
}