<?php
namespace Controllers;

use \Members\Artist;

class ArtistsController extends Controller{
    public function id($params){
        if(!isset($params[0]) || !is_numeric($params[0])){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $artist = Artist::id($id);

        $artist->getMusic();

        $params = [
            'artist' => $artist,
            'musics' => $artist->music
        ];
        
        echo $this->render("artist", $params);
    }
}