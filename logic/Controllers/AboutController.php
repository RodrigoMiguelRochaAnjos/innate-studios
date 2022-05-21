<?php
namespace Controllers;

use \Members\Artist;
use \Models\Studio;


class AboutController extends Controller{
    public function view(){

        echo $this->render("about");
    }

}