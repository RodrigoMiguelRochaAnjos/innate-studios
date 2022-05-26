<?php
namespace app\core;

class Router {
    public array $routes = [];

    public function get(string $path, $name){

        if(gettype($name) == "string"){
            $ctrl = ucfirst($name)."Controller";

            $this->routes[$path] = [
                'controller' => $ctrl,
                'name' => $name,
                'type' => "controller"
            ];
        }else if(gettype($name) == "object"){
            $this->routes[$path] = [
                'controller' => $name,
                'name' => "callable",
                'type' => "callable"
            ];
        }

    }

    public function resolve(){
        $uri = $_SERVER['REQUEST_URI'];

        $found = false;
    
        foreach($this->routes as $path => $page){
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
