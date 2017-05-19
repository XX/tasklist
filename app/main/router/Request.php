<?php

namespace router;

use router\Route;
use router\Response;

class Request
{
    public static function create($uri = null)
    {
        if (empty($uri)) {
            $uri = static::getCurrentUri();
        }
        return new Request($uri);
    }
    
    public static function getCurrentUri()
    {
        $uri = null;
        if (!empty($_SERVER['PATH_INFO'])) {
            $uri = $_SERVER['PATH_INFO'];
        } else if (isset($_SERVER['REQUEST_URI'])) {
            $uri = rawurldecode(
                    parse_url(
                            $_SERVER['REQUEST_URI'],
                            PHP_URL_PATH
                    ));
        }
        return $uri;
    }

    private $uri;
    public $params = [];
    
    public function __construct($uri)
    {
        $this->uri = trim($uri, '/');
    }

    public function execute()
    {
        $params = null;
        $route = null;
        $routes = Route::allRoutes();
        
        foreach ($routes as $name => $route) {
            if ($params = $route->match($this->uri)) {
                break;
            }
        }
        
        $response = Response::create('request error');
        
        if ($params) {
            $this->params = $params;
            
            $className = 'controller\\' . $params['controller'] . 'Controller';
            if (class_exists($className)) {
                $class = new \ReflectionClass($className);
                $controller = $class->newInstance($this, $response);

                $methodName = $params['action'] . 'Action';
                if ($class->hasMethod($methodName)) {
                    $class->getMethod($methodName)->invoke($controller);
                }
            }
        }
        
        return $response;
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
