<?php

namespace model;

use service\AbstractActiveRecord;

abstract class AbstractEntity extends AbstractActiveRecord
{
    public $id;

    public function __construct($array = [])
    {
        foreach ($array as $key => $value) {
            $this->$key = $array[$key];
        }
    }
}