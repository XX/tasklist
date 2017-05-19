<?php

use router\Route;

session_start();
require_once 'error.php';

Route::set('default', '(<controller>(/<action>(/<id>)))', [
    'controller' => 'Task',
    'action' => 'index'
]);

Route::set('view', '(<controller>(/<id>))', [
    'action' => 'view'
]);

Application::$config = [
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'tasklist',
        'username' => 'tasklist',
        'password' => 'tasklist'
    ],
    'viewDir' => dirname(__DIR__) . '/main/view/',
    'uploadDir' => dirname(dirname(__DIR__)) . '/web/public/upload/',
    'uploadUri' => '/upload/',
    'image' => [
        'width' => 320,
        'height' => 240
    ],
    'tasks_on_page' => 3
];
$app = new Application();

return $app;