<?php
namespace app\core;

class Router {
    public Request $request;
    public Response $response;
    public array $routes = [];

    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $name){
        $this->routes['get'][$path] = $name;

    }
    public function post(string $path, $name){
        $this->routes['post'][$path] = $name;
    }

    public function resolve(){
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $func = $this->request->getFunction();
        $params = $this->request->getParams();

        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false){
            $this->response->setStatusCode(404);
            exit;
        }

        if(is_string($callback)){
            $controller_name = '\\Controllers\\'.ucfirst($callback).'Controller';
            $controller = new $controller_name();
            $controller->$func($params);
        }else{
            $callback();
        }
        
    }
    
    
}
