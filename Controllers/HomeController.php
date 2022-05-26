<?php
namespace Controllers;

use app\core\Controller;

use \Studio\Productions\Music;
use \Models\Studio;

class HomeController extends Controller{
    public function view(){
        $studio = new Studio();
        $music = new Music();
        
        $studio->getArtists();
        $music = $music->getAllMusic();

        $params = [
            'music' => $music,
            'artists' => $studio->artists
        ];

        echo $this->render("home", $params);
    }
}