<?php
use \Database\Query;
use \Members\Artist;

class Studio { 
    public $members = [];
    
    public function __construct(){
        
    }

    public function getMembers(){
        $params = ["id", "name", "email", "password", "date_joined", "token", "type", "age"];

        $results = \Database\Query::read($params, "members");

        foreach($results as $result){
            $artist = Artist::params($result["name"], $result["age"], $result["email"], $result["password"], $result["date_joined"],$result["token"]);
            $artist->id = $result["id"];

            $this->members[] = $artist;
        }

    }
}
