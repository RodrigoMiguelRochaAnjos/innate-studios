<?php
namespace Members;

use \Database\Query;

abstract class Member {
    public int $id=0;
    public string $name;
    public string $age;
    public string $email;
    public string $password;
    protected string $date_joined;
    protected string $token;

    function __construct(){
        
    }

    public abstract function save();
    public abstract function add();

    public static function params(string $name, int $age, string $email, string $password, string $date_joined = '', string $token = ''){
        $instance = new static();

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
        $instance = new static();

        $fields = ["id", "name", "email", "password", "date_joined", "token"];

        $results = \Database\Query::read($fields, "members", "id = ?", [$id]);

        foreach($results as $result){
            $instance->id = $result['id'];
            $instance->name = $result['name'];
            $instance->email = $result['email'];
            $instance->password = $result['password'];
            $instance->date_joined = $result['date_joined'];
            $instance->token = $result['token'];
        }

        return $instance;
    }

    private function generateToken(){
        $token = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $token = str_shuffle($token);
        $token = substr($token, 0, 16);

        $this-> token = $token;
    }

    
}