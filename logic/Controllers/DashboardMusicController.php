<?php
namespace Controllers;

use \Members\Artist;
use \Studio\Productions\Music;
use \Models\Studio;

class DashboardMusicController extends Controller{
    private Artist $artist;

    public function view(){
        if(!isset($_SESSION['id']) || !is_numeric($_SESSION['id'])){
            header("Location: /login");
            exit();
        }
        $id= $_SESSION['id'];

        $this->artist = Artist::id($id);

        $this->artist->getMusic();

        $params = [
            'selected' => "title",
            'music' => $this->artist->music,
            'artist' => $this->artist
        ];
        echo $this->render("dashboard.music", $params, "dashboard");
    }

    public function search(){

        if(
            !isset($_POST['filter']) || $_POST['filter'] =="" ||
            !isset($_POST['search']) || $_POST['search'] ==""
        ) {
            header("Location: /dashboard-music");
            exit();
        }

        $field = $_POST['filter'];
        $query = $_POST['search'];
        $id= $_SESSION['id'];

        $this->artist = Artist::id($id);
        $music = new Music();

        $songs= $music->search($field, $query, $this->artist->id);

        $params = [
            'selected' => $field,
            'music' => $songs,
            'artist' => $this->artist
        ];
        echo $this->render("dashboard.music", $params, "dashboard");
    }

}