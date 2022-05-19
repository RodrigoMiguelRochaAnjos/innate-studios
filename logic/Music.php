<?php
namespace Studio\Productions;

use \Database\Query;

class Music
{
    public int $id;
    public string $title;
    public string $file;
    public string $background;
    public int $authorId;
    private string $dateAdded;
    private string $datePublished;

    public function __construct(){
        
    }

    public static function params(string $title, string $file, string $datePublished, string $background = ''){
        $instance = new static();

        $instance->title = $title;
        $instance->file = $file;
        $instance->background = '';
        $instance->dateAdded = date("Y-m-d H:i:s");
        $instance->datePublished = $datePublished;

        return $instance;
    }
    public static function id(int $id){
        $instance = new static();

        $params= ["id", "title", "file", "background", "artist_id", "date_added", "date_published"];

        $results = \Database\Query::read($params, "music", "id = ?", [$id]);

        foreach ($results as $result) {
            $instance->id = $result['id'];
            $instance->title = $result["title"];
            $instance->file = $result["file"];
            $instance->background = $result["background"];
            $instance->authorId = $result["artist_id"];
            $instance->dateAdded = $result["date_added"];
            $instance->datePublished = $result['artist_id'];
        }
        

        return $instance;
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
            'artist_id' => $this->authorId
        ];
        
        \Database\Query::update($params, "music", "id = ?", [$this->id]);
    }

    public function add() {
        $params = [
            'title' => $this->title,
            'file' => $this->file,
            'background' => $this->background,
            'artist_id' => $this->authorId,
            'date_added' => $this->dateAdded,
            'date_published' => $this->datePublished
        ];
        
        \Database\Query::create($params, "music");
    }
}


