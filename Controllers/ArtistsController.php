<?php
namespace Controllers;

use app\core\Controller;

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

        $me="";
        if(isset($_SESSION['id']) && is_numeric($_SESSION['id'])){
            $me = Artist::id($_SESSION['id']);
        }

        $params = [
            'artist' => $artist,
            'me' => $me,
            'bands' => $artist->bands
        ];
        
        echo $this->render("artist", $params);
    }

    public function follow($params){
        if(
            !isset($params[0]) || !is_numeric($params[0]) ||
            !isset($_SESSION['id']) || !is_numeric($_SESSION['id'])
        ){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $artist = Artist::id($id);

        $me = Artist::id($_SESSION['id']);

        if($artist->id != $_SESSION['id']) {
            if(!in_array($artist->id, $me->following)){
                $artist->follow($_SESSION['id']);
            }else{
                $me->unfollow($id);
            }
        }
        
        header("Location: /artists");
    }
}