<?php

namespace router;

class Response
{
    private $content;
    
    public static function create($content = 'response')
    {
        return new Response($content);
    }
    
    public function __construct($content)
    {
        $this->content = $content;
    }
    
    public function body($content = null)
    {
        if (!is_null($content)) {
            $this->content = $content;
        }
        return $this->content;
    }

    public function redirect($uri)
    {
        header("Location: $uri");
        die();
    }
}
