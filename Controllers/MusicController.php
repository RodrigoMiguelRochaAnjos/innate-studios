<?php
namespace Controllers;

use app\core\Controller;

use \Members\Artist;
use \Studio\Productions\Music;

class MusicController extends Controller{
    public function view(){
        $music = new Music();
        $me = "";
        if(isset($_SESSION['id'])){
            $me = Artist::id($_SESSION['id']);
        }
        $params = [
            'music' => $music->getAllMusic(),
            'me' => $me
        ];
        echo $this->render("music", $params);
    }

    public function id($params){
        if(!isset($params[0]) || !is_numeric($params[0])){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $music = Music::id($id);

        $me = "";
        if(isset($_SESSION['id'])){
            $me = Artist::id($_SESSION['id']);
        }

        $params = [
            'music' => $music,
            'me' => $me
        ];
        
        echo $this->render("music-single", $params);
    }
    public function like($params){
        if(
            !isset($params[0]) || !is_numeric($params[0]) ||
            !isset($_SESSION['id']) || !is_numeric($_SESSION['id'])
        ){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $music = Music::id($id);

        $me = "";
        if(isset($_SESSION['id'])){
            $me = Artist::id($_SESSION['id']);
        }

        if(!in_array($music->id, $me->songs_liked)){
            $music->like($_SESSION['id']);
        }else{
            $me->dislike($music->id);
        }
        
        header("Location: /music");
    }
}