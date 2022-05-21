<?php
namespace Controllers;

class HomeController extends Controller{
    public function view(){
        echo $this->render("home");
    }
}