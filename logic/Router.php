<?php
class Router {
    public static array $routes = [];

    public static function get(string $path, string $name){
        $ctrl = ucfirst($name)."Controller";

        self::$routes[$path] = [
            'controller' => $ctrl,
            'name' => $name
        ];

    }
    
    public static function run(){
        $uri = $_SERVER['REQUEST_URI'];

        $found = false;
    
        foreach(self::$routes as $path => $page){
            $arguments = explode("/", $uri);

            array_splice($arguments, 0, 1);

            $argument = '';

            if(isset($arguments[0])){
                $argument = $arguments[0];
            }

            if($path !== '/'.$argument) continue;

            array_splice($arguments, 0, 1);

            $found = true;

            $controller = "\\Controllers\\". $page['controller'];

            
            $controller = new $controller();
            
            if(isset($arguments[0])){
                $method = $arguments[0];
                if(method_exists($controller, $method)){
                    array_splice($arguments, 0, 1);
    
                    $controller->$method($arguments);
                }
            }

            echo $controller->view();
        }
    
        if(!$found){
            echo "Page not found";
        }
    }
}
