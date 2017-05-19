<?php

namespace router;

class Route
{
    const DEFAULT_CONTROLLER = 'Index';
    const DEFAULT_ACTION = 'index';
    
    private static $routes = [];
    
    public static function set($name, $uri, $defaults = null)
    {
        static::$routes[$name] = new Route($uri, $defaults);
    }
    
    public static function get($name)
    {
        return static::$routes[$name];
    }
    
    public static function allRoutes()
    {
        return static::$routes;
    }
    
    public $uri;
    public $regexp;
    public $defaults;

    public function __construct($uri, $defaults = null)
    {
        $this->uri = $uri;
        $this->regexp = $this->makeRegexp($uri);
        $this->defaults = $defaults;
    }
    
    public function match($uri)
    {
        if (!preg_match($this->regexp, $uri, $matches)) {
            return false;
        }
        
        $params = [];
        
        foreach ($matches as $key => $value) {
            if (!is_int($key)) {
                $params[$key] = $value;
            }
        }

        if (isset($this->defaults)) {
            foreach ($this->defaults as $key => $value) {
                if (empty($params[$key])) {
                    $params[$key] = $value;
                }
            }
        }

        if (!empty($params['controller'])) {
            $params['controller'] = $this->makeCamelName($params['controller']);
        } else {
            $params['controller'] = static::DEFAULT_CONTROLLER;
        }

        if (!empty($params['action'])) {
            $params['action'] = lcfirst($this->makeCamelName($params['action']));
        } else {
            $params['action'] = static::DEFAULT_ACTION;
        }

        foreach ($params as $key => $value) {
            if ($key !== 'controller' && $key !== 'action') {
                $_GET[$key] = $value;
            }
        }
        
        return $params;
    }
    
    private function makeCamelName($name)
    {
        return str_replace(' ', '',
            ucwords(
                str_replace('_', ' ', strtolower($name) )
            )
        );
    }

    private function makeRegexp($uri)
    {
        $exp = preg_replace('#[^\d\w\s()<>]#', '\\\\$0', $uri);
        $exp = str_replace([ '(', ')' ], [ '(?:', ')?' ], $exp);
        $exp = str_replace([ '<', '>' ], [ '(?<', '>[\w\d_]+)' ], $exp);
        return '#^' . $exp . '$#i';
    }
    
}
