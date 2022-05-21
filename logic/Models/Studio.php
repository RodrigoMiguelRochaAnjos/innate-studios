<?php
namespace Models;

use \Database\Query;
use \Members\Artist;
use \Studio\Productions\Music;

class Studio { 
    public array $members = [];
    public array $artists = [];
    public array $music = [];
    
    public function __construct(){
        
    }

    public function getMembers(){
        $params = ["id", "name", "email", "password", "date_joined", "token", "type", "age","bio",'pfp'];

        $results = \Database\Query::read($params, "members");

        foreach($results as $result){
            $pfp = 'default.png';
            if($result["pfp"] != null){
                $pfp = $result["pfp"];
            }
            $artist = Artist::params($result["name"], $result["age"], $result["email"], $result["password"], $result["date_joined"],$result["token"], $pfp);
            $artist->id = $result["id"];
            $artist->bio = $result["bio"];

            $this->members[] = $artist;
        }

    }
    public function getArtists(){
        $params = ["id", "name", "email", "password", "date_joined", "token", "type", "age","bio",'pfp'];

        $results = \Database\Query::read($params, "members");

        foreach($results as $result){
            if($result["type"] == "Artist"){
                $pfp = 'default.png';
                if($result["pfp"] != null){
                    $pfp = $result["pfp"];
                }
                $artist = Artist::params($result["name"], $result["age"], $result["email"], $result["password"], $result["date_joined"],$result["token"], $pfp);
                $artist->id = $result["id"];
                $artist->bio = $result["bio"];
    
                $this->artists[] = $artist;
            }
        }

    }
}
