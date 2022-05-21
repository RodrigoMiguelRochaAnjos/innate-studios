<?php
namespace Controllers;

use \Members\Artist;
use \Models\Studio;


class DashboardController extends Controller{
    public function view(){
        if(!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])){
            header("Location: /login");
            exit();
        }
        
        $id= $_SESSION['id'];

        $artist = Artist::id($id);

        $artist->getMusic();

        $params = [
            'music' => $artist->music,
            'artist' => $artist
        ];

        echo $this->render("dashboard", $params , "dashboard");
    }

}