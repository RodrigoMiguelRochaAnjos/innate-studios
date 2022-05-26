<?php
namespace Controllers;

use app\core\Controller;

use \Studio\Band;

class BandsController extends Controller{
    public function view(){
        $bands = new Band();

        $params = [
            'bands' => $bands->getAllBands()
        ];
        echo $this->render("bands", $params);
    }

    public function id($params){
        if(!isset($params[0]) || !is_numeric($params[0])){
            Router::$routes['/404']();
            exit();
        }

        $id = $params[0];
        
        $music = Music::id($id);

        $params = [
            'music' => $music
        ];
        
        echo $this->render("music-single", $params);
    }
}