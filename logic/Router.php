<?php
class Router {
    public static array $routes = [];

    public static function get(string $path, callable $callback){
        self::$routes[$path] = $callback;
    }
    
    public static function run(){
        $uri = $_SERVER['REQUEST_URI'];

        $found = false;
    
        foreach(self::$routes as $path => $callback){
            $arguments = explode("/", $uri);

            array_splice($arguments, 0, 1);

            $argument = '';

            if(isset($arguments[0])){
                $argument = $arguments[0];
            }

            if($path !== '/'.$argument) continue;

            array_splice($arguments, 0, 1);

            $found = true;
            $callback($arguments);
        }
    
        if(!$found){
            $notFoundCallback = self::$routes['/404'];
            $notFoundCallback();
        }
    }
}
