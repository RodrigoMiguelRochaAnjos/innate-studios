<?php
namespace Members;

use \Database\Query;

abstract class Member {
    public array $following = [];
    public int $id=0;
    public string $name;
    public string $bio = "";
    public string $pfp;
    public string $email;
    public string $password;
    public string $token;
    public string $date_joined;
    public string $date_updated;

    function __construct(){
        
    }

    public abstract function save();
    public abstract function add();

    // public static function params(string $name, int $bio, string $email, string $password , string $token = '', string $pfp = 'default.png'){
    //     $instance = new static();

    //     $instance->id = $id;
    //     $instance->name = $name;
    //     $instance->bio = $bio;
    //     $instance->pfp = $pfp;
    //     $instance->email = $email;
    //     $instance->password = $password;
    //     $instance->token = $token;

    //     if($instance->date_joined == ''){
    //         $instance-> date_joined = date("Y-m-d H:i:s");
    //     }
    //     if($instance->date_updated == ''){
    //         $instance-> date_updated = date("Y-m-d H:i:s");
    //     }

    //     if($instance->token == ''){
    //         $instance->generateToken();
    //     }

    //     return $instance;
    // }

    

    public static function authenticate(string $email, string $password){
        $instance = new static();

        $fields = ["id", "name", "bio", "pfp", "email", "password", "token", "date_joined", "date_updated"];

        $results = (new \Database\Query)->read($fields, "members", "email = ?", [$email]);


        foreach($results as $result){
            if(password_verify($password, $result['password'])){
                $instance->id = $result['id'];
                $instance->name = $result['name'];
                $instance->bio = $result['bio'];
                $instance->pfp = $result['pfp'];
                $instance->email = $result['email'];
                $instance->password = $result['password'];
                $instance->token = $result['token'];
                $instance->date_joined = $result['date_joined'];
                $instance->date_updated = $result['date_updated'];

                foreach ((new \Database\Query)->read(["id_target"], "artist_followers", "id_member = ?", [$instance->id]) as $res) {
                    $instance->following[] =  $res['id_target'];
                }
                
                break;
            }
        }

        return $instance;
    }

    protected function generateToken(){
        $token = '1234567890qwertyuiopasdfghjklzxcvbnm';
        $token = str_shuffle($token);
        $token = substr($token, 0, 16);

        $this-> token = $token;
    }

    
}