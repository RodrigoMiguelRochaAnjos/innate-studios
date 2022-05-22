<?php
class Router {
    public static array $routes = [];

    public static function get(string $path, $name){

        if(gettype($name) == "string"){
            $ctrl = ucfirst($name)."Controller";

            self::$routes[$path] = [
                'controller' => $ctrl,
                'name' => $name,
                'type' => "controller"
            ];
        }else if(gettype($name) == "object"){
            self::$routes[$path] = [
                'controller' => $name,
                'name' => "callable",
                'type' => "callable"
            ];
        }

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

            if($page['type'] == "controller"){
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
            }else{
                $page['controller']();
            }

        }
    
        if(!$found){
            echo "Page not found";
        }
    }
}
