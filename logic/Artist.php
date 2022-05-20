<?php
namespace Members;

use \Studio\Productions\Music;

class Artist extends Member{
    public array $music=[];

    function __construct(){

    }

    public function getMusic(){
        $params = ["id", "title", "file", "background", "artist_id", "date_added", "date_published"];

        $results = \Database\Query::read($params, "music", "artist_id = ?", [$this->id]);

        foreach($results as $result){
            $background = "";
            if($result['background'] != null){
                $background = $result['background'];
            }

            $music = Music::params($result['title'], $result['file'], $result['date_published'], $background);
            $music->id = $result['id'];
            $music->dateAdded = $result['date_added'];
            $music->authorId = $result['artist_id'];

            $this->music[] = $music;
        }

    }


    public function addMusic(Music $music) : void{
        if($this->id == 0){
            throw new Exception("User must be fetched first");
            exit();
        }
        if($music->getDateAdded() == ""){
            $music->setDateAdded(date("Y-m-d H:i:s"));
        }

        $music->authorId= $this->id;

        $music->add();
    }
    
    public function save() {
        $params = [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email,
            'password' => $this->password,
            'date_joined' => $this->date_joined,
            'token' => $this->token
        ];
        
        \Database\Query::update($params, "members", "id = ?", [$this->id]);
    }

    public function add() {
        $params = [
            'name' => $this->name,
            'age' => $this->age,
            'email' => $this->email,
            'password' => $this->password,
            'date_joined' => $this->date_joined,
            'token' => $this->token,
            'type' => "Artist"
        ];
        
        \Database\Query::create($params, "members");
    }
}