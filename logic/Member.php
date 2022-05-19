<?php
namespace Members;

class Member {
    public string $name;
    public string $age;
    public string $email;
    public string $password;
    protected string $date_joined;
    protected string $token;

    private function __construct(){
        
    }

    public static function params(string $name, int $age, string $email, string $password, string $date_joined = '', string $token = ''){
        $instance = new self();

        $instance->name = $name;
        $instance->age = $age;
        $instance->email = $email;
        $instance->password = $password;
        $instance->date_joined = $date_joined;
        $instance->token = $token;

        if($instance->date_joined == ''){
            $instance-> date_joined = date("Y-m-d H:i:s");
        }

        if($instance->token == ''){
            $instance->generateToken();
        }

        return $instance;
    }

    public static function id(int $id){
        
    }

    private function generateToken(){
        $token = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $token = str_shuffle($token);
        $token = substr($token, 0, 16);

        $this-> token = $token;
    }

    
}