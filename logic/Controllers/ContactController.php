<?php
namespace Controllers;

use \Members\Artist;
use \Models\Studio;


class ContactController extends Controller{
    public function view(){

        echo $this->render("contact");
    }

}