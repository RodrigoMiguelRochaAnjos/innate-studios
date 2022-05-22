<?php
namespace Controllers;

use \Members\Artist;
use \Models\Studio;


class ArtistsController extends Controller{
    public function view(){
        $studio = new Studio();

        $studio->getArtists();

        echo $this->render("artists", ['artists' => $studio->artists]);
    }

    public function id($params){
        if(!isset($params[0]) || !is_numeric($params[0])){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $artist = Artist::id($id);

        $artist->getBands();

        $params = [
            'artist' => $artist,
            'bands' => $artist->bands
        ];
        
        echo $this->render("artist", $params);
    }
}