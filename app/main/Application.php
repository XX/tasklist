<?php

use router\Request;

class Application
{
    static public $config = [];

    public function run()
    {
        echo Request::create()
                ->execute()
                ->body();
    }
}
