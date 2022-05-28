<?php
namespace Controllers;

use app\core\Controller;

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

        $artist->getBands();


        $params = [
            'bands' => $artist->bands,
            'artist' => $artist
        ];

        echo $this->render("dashboard/home", $params , "dashboard");
    }

}