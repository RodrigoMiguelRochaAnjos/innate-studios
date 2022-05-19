<?php
namespace Members;

use \Studio\Productions\Music;

class Artist extends Member{

    function __construct(){

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