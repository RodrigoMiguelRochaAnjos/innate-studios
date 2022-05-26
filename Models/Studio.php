<?php
namespace Models;

use \Database\Query;
use \Members\Member;
use \Members\Artist;
use \Studio\Productions\Music;

class Studio { 
    public array $members = [];
    public array $artists = [];
    public array $music = [];
    
    public function __construct(){
        
    }

    public function getMembers(){

        $fields = ["id", "name", "bio", "pfp", "email", "password", "token", "date_joined", "date_updated"];

        $results = \Database\Query::read($params, "members");

        foreach($results as $result){
            $artist = Member::params($result['name'], $result['bio'], $result['email'], $result['password'] , $result['token'], $result['pfp']);

            $artist->id = $result['id'];
            $artist->date_joined = $result['date_joined'];
            $artist->date_updated = $result['date_updated'];

            $this->members[] = $artist;
        }

    }
    public function getArtists(){

        $results = \Database\Query::custom("SELECT 
            m.id, 
            m.name, 
            m.bio, 
            m.pfp, 
            m.email, 
            m.password, 
            m.token,
            a.age,
            a.followers,
            m.date_joined, 
            m.date_updated
            FROM members m 
            INNER JOIN artists a on a.id_member = m.id
        ");
        
        foreach($results as $result){
            $artist = Artist::params($result[1], $result[2], $result[4],$result[7], $result[5] , $result[6], $result[3]);

            $artist->id = $result[0];
            $artist->followers = $result[8];
            $artist->date_joined= $result[9];
            $artist->date_updated = $result[10];
            if(!isset($_SESSION['id']) || $_SESSION['id'] != $artist->id){
                $this->artists[] = $artist;
            }
        }
    }
}
