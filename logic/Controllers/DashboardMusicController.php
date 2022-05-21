<?php
namespace Controllers;

use \Members\Artist;
use \Models\Studio;

class DashboardMusicController extends Controller{
    public function view(){
        $id= $_SESSION['id'];

        $artist = Artist::id($id);

        $artist->getMusic();

        $params = [
            'music' => $artist->music,
            'artist' => $artist
        ];
        echo $this->render("dashboard.music", $params, "dashboard");
    }

}