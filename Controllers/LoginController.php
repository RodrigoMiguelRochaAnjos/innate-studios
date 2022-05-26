<?php
namespace Controllers;

use app\core\Controller;

use \Members\Artist;

class LoginController extends Controller{
    public function view(){
        if(isset($_SESSION['id'])){
            header("Location: /dashboard");
        }
        echo $this->render("login", []);
    }

    public function authenticate(){
        if(
            !isset($_POST['email']) || $_POST['email'] == "" ||
            !isset($_POST['password']) || $_POST['password'] == ""
        ){
            header("Location: /login");
            exit();
        }
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $artist = Artist::authenticate($email, $password);

        if(isset($artist->name) && $artist->name != ""){
            $_SESSION['id']= $artist->id;

            header("Location: /dashboard");
        }

        echo $this->render("login", ['error' => 'invalid login credentials']);

    }
}