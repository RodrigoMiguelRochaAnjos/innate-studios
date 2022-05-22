<?php
namespace Controllers;

use \Studio\Productions\Music;

class HomeController extends Controller{
    public function view(){
        $music = new Music();

        $music = $music->getAllMusic();

        echo $this->render("home", ['music' => $music]);
    }
}