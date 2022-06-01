<?php
namespace app\core;

class Request {
    public function getPath(){
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        $position = strpos($uri, '/',1);

        if($position === false){
            return $uri;
        }

        return substr($uri, 0, $position);


    }
    public function getMethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getFunction(){
        $pos = strpos($_SERVER['REQUEST_URI'], $this->getPath());
        if($pos === false){
            return 'view';
        }
        $method = substr_replace($_SERVER['REQUEST_URI'], "", $pos, strlen($this->getPath()));

        if(strlen($method) === 0){
            return 'view';
        }
        $method = ltrim($method, '/');

        $method = explode("/",$method)[0];

        return $method;
    }

    public function getParams(){
        $str_to_remove = $this->getPath().'/'. $this->getFunction().'/';
        $pos = strpos($_SERVER['REQUEST_URI'], $str_to_remove);
        if($pos === false){
            return 'view';
        }
        $params = substr_replace($_SERVER['REQUEST_URI'], "", $pos, strlen($str_to_remove));

        $params = explode("/",$params);

        return $params;
    }
}
