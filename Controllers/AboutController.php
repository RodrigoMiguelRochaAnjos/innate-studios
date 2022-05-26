<?php
namespace Controllers;

use app\core\Controller;

use \Members\Artist;
use \Models\Studio;


class AboutController extends Controller{
    public function view(){

        echo $this->render("about");
    }

}