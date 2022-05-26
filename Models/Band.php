<?php
namespace Studio;

use \Database\Query;

class Band
{
    public int $id;
    public string $name;
    public string $image;
    public int $num_songs;
    public int $followers;
    public string $date_created;
    public string $date_updated;

    public function __construct(){
        
    }

    public static function params(string $name, string $image, int $num_songs = 0, int $followers = 0){
        $instance = new static();

        $instance->name = $name;
        $instance->image = $image;
        $instance->num_songs = $num_songs;
        $instance->followers = $followers;
        $instance->date_released = date("Y-m-d H:i:s");
        $instance->date_updated = date("Y-m-d H:i:s");

        return $instance;
    }
    
    public static function id(int $id){
        $instance = new static();

        $params= ["id", "name", "image", "num_songs", "followers", "date_created", "date_updated"];

        $results = \Database\Query::read($params, "band", "id = ?", [$id]);

        foreach ($results as $result) {
            $instance->id = $result['id'];
            $instance->name = $result['name'];
            $instance->image = $result['image'];
            $instance->num_songs = $result['num_songs'];
            $instance->followers = $result['followers'];
            $instance->date_created = $result['date_created'];
            $instance->date_updated = $result['date_updated'];
        }
        

        return $instance;
    }

    public function getAlbums(){
        $params= ["id", "title", "image", "band_id", "num_songs", "date_released", "date_updated"];

        $results = \Database\Query::read($params, "albums", "band_id = ?", [$this->id]);

        $all_albums=[];

        foreach ($results as $result) {
            $album = Album::params($result['title'],$result['image'],$result['band_id'],$result['num_songs']);
            $album->id = $result['id'];
            $album->date_released = $result['date_released'];
            $album->date_updated = $result['date_updated'];

            $all_albums[] = $album;
        }

        return $all_albums;
    }

    public function getAllBands(){
        $params= ["id","name","image","num_songs","followers","date_created","date_updated"];

        $results = \Database\Query::read($params, "band");

        $all_bands=[];
        foreach ($results as $result) {
            $band = Band::params($result['name'],$result['image'],$result['num_songs'],$result['followers']);
            $band->id = $result['id'];
            $band->date_created = $result['date_created'];
            $band->date_updated = $result['date_updated'];

            $all_bands[] = $band;
        }

        return $all_bands;
    }


    public function save() {
        $params = [
            'name' => $this->name,
            'image' => $this->image,
            'num_songs' => $this->num_songs,
            'followers' => $this->followers,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::update($params, "music", "id = ?", [$this->id]);
    }

    public function add() {
        $params = [
            'name' => $this->name,
            'image' => $this->image,
            'num_songs' => $this->num_songs,
            'followers' => $this->followers,
            'date_created' => $this->date_created,
            'date_updated' => $this->date_updated
        ];
        
        \Database\Query::create($params, "music");
    }
}


