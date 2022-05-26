<?php
namespace Studio;

use \Database\Query;
use \Studio\Productions\Music;

class Album
{
    public int $id;
    public string $title;
    public string $image;
    public int $band_id;
    public int $num_songs;
    public string $date_released;
    public string $date_updated;

    public function __construct(){
        
    }

    public static function params(string $title, string $image, int $band_id, int $num_songs = 0){
        $instance = new static();

        $instance->title = $title;
        $instance->image = $image;
        $instance->band_id = $band_id;
        $instance->num_songs = $num_songs;
        $instance->date_released = date("Y-m-d H:i:s");
        $instance->date_updated = date("Y-m-d H:i:s");

        return $instance;
    }
    
    public static function id(int $id){
        $instance = new static();

        $params= ["id", "title", "image", "band_id", "num_songs", "date_released", "date_updated"];

        $results = \Database\Query::read($params, "albums", "id = ?", [$id]);

        foreach ($results as $result) {
            $instance->id = $result['id'];
            $instance->title = $result['title'];
            $instance->image = $result['image'];
            $instance->band_id = $result['band_id'];
            $instance->num_songs = $result['num_songs'];
            $instance->date_released = $result['date_released'];
            $instance->date_updated = $result['date_updated'];
        }
        

        return $instance;
    }

    public function getMusic(){
        $params= ["id", "title", "file", "background", "id_album", "views", "likes", "date_released", "date_updated"];

        $results = \Database\Query::read($params, "music", "id_album = ?", [$this->id]);

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

    public function save() {
        $params = [
            'title' => $this->title,
            'image' => $this->image,
            'band_id' => $this->band_id,
            'num_songs' => $this->num_songs,
            'date_released' => $this->date_released,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::update($params, "albums", "id = ?", [$this->id]);
    }

    public function add() {
        $params = [
            'title' => $this->title,
            'image' => $this->image,
            'band_id' => $this->band_id,
            'num_songs' => $this->num_songs,
            'date_released' => $this->date_released,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::create($params, "albums");
    }
}


