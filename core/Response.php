<?php
namespace app\core;

class Response
{
    private int $status_code;
    
    public function setStatusCode(int $code){
        $this->status_code = $code;
        http_response_code($code);
    }

    public function getStatusCode(){
        return $this->status_code;
    }
}
