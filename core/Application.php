<?php
namespace app\core;

class Application {
    public static String $ROOT_DIR;
    public Router $router;

    public function __construct($rootPath){
        self::$ROOT_DIR = $rootPath;

        $this->router = new Router();
    }
    
    public function run(){
        $this->router->resolve();
    }
}
