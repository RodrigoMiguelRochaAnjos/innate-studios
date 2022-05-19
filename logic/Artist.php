<?php
namespace Members;

class Artist extends Member{
    private array $music = [];

    function __construct(){

    }

    public function addMusic(Music $music){
        if($music->getDateAdded() == ""){
            $music->setDateAdded(date("Y-m-d H:i:s"));
        }

        $this->music[] = $music;
    }
}