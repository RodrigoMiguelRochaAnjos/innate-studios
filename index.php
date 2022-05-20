<?php
require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Studio.php';
require_once 'logic/Member.php';
require_once 'logic/Artist.php';
require_once 'logic/Music.php';
require_once 'logic/Router.php';

Router::get('/', function ($args) {
    require_once 'resources/views/home.phtml';
});

Router::get('/artists', function ($args){
    if(isset($args[0]) && $args[0] == "id"){
        if(!isset($args[1]) || !is_numeric($args[1])){
            Router::$routes['/404']();
            exit();
        }

        $id = $args[1];

        require_once 'resources/views/artist.phtml';
    }else{
        require_once 'resources/views/artists.phtml';
    }
});

Router::get('/contact-us', function ($args) {
    require_once 'resources/views/contact.phtml';
});

Router::get('/404', function (){
    echo "Page not found";
});



Router::run();