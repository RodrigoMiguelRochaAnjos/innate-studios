<?php
namespace Studio\Productions;

use \Database\Query;

class Music
{
    public int $id;
    public string $title;
    public string $file;
    public string $background;
    public int $id_album;
    public int $views;
    public int $likes;
    public string $date_released;
    public string $date_updated;

    public function __construct(){
        
    }

    public static function params(string $title, string $file, string $id_album, string $background = ''){
        $instance = new static();

        $instance->title = $title;
        $instance->file = $file;
        $instance->id_album = $id_album;
        $instance->background = $background;
        $instance->views = 0;
        $instance->likes = 0;
        $instance->date_released = date("Y-m-d H:i:s");
        $instance->date_updated = date("Y-m-d H:i:s");

        return $instance;
    }
    public static function id(int $id){
        $instance = new static();

        $params= ["id", "title", "file", "background", "id_album", "views", "likes", "date_released", "date_updated"];

        $results = \Database\Query::read($params, "music", "id = ?", [$id]);

        foreach ($results as $result) {
            $instance->id = $result["id"];
            $instance->title = $result["id"];
            $instance->file = $result["file"];
            $instance->id_album = $result['id_album'];
            $instance->background = $result['background'];
            $instance->views = $result['views'];
            $instance->likes = $result['likes'];
            $instance->date_released = $result['date_released'];
            $instance->date_updated = $result['date_updated'];
        }
        

        return $instance;
    }

    public function search(string $field, string $query, int $album_id){
        $params= ["id", "title", "file", "background", "id_album", "views", "likes", "date_released", "date_updated"];

        
        if(!in_array($field, $params)){
            echo "page not found";
            exit();
        }

        $results = \Database\Query::read($params, "music", "$field LIKE ? and album_id = ?", ["%$query%", $id]);

        $ret_array=[];

        foreach ($results as $result) {
            $this->id = $result["id"];
            $this->title = $result["id"];
            $this->file = $result["file"];
            $this->id_album = $result['id_album'];
            $this->background = $result['background'];
            $this->views = $result['views'];
            $this->likes = $result['likes'];
            $this->date_released = $result['date_released'];
            $this->date_updated = $result['date_updated'];

            $ret_array[] = $this;
        }

        return $ret_array;
    }

    public function getAllMusic(){
        $params= ["id", "title", "file", "background", "id_album", "views", "likes", "date_released", "date_updated"];

        $results = \Database\Query::read($params, "music");

        $all_music=[];

        foreach($results as $result){
            $music = Music::params($result['title'], $result['file'], $result['id_album'], $result['background']);
            $music->id = $result['id'];
            $music->views = $result['views'];
            $music->likes = $result['likes'];
            $music->dateAdded = $result['date_released'];
            $music->date_updated = $result['date_updated'];

            $all_music[] = $music;
        }

        return $all_music;
    }


    public function changeAuthor(int $id) : void{
        $this->authorId = $id;

        $this->save();
    }

    public function setDateAdded(string $date) : void {
        $this->dateAdded = $date;
    }
    
    public function getDateAdded() : string {
        return $this->dateAdded;
    }

    public function save() {
        $params = [
            'title' => $this->title,
            'file' => $this->file,
            'background' => $this->background,
            'id_album' => $this->id_album,
            'views' => $this->views,
            'likes' => $this->likes,
            'date_released' => $this->date_released,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::update($params, "music", "id = ?", [$this->id]);
    }

    public function add() {
        $params = [
            'title' => $this->title,
            'file' => $this->file,
            'background' => $this->background,
            'id_album' => $this->id_album,
            'views' => $this->views,
            'likes' => $this->likes,
            'date_released' => $this->date_released,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::create($params, "music");
    }
}


