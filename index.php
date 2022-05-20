<?php
require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Controller.php';
require_once 'logic/Controllers/HomeController.php';
require_once 'logic/Controllers/ArtistsController.php';
require_once 'logic/Studio.php';
require_once 'logic/Models/Member.php';
require_once 'logic/Models/Artist.php';
require_once 'logic/Models/Music.php';
require_once 'logic/Router.php';

Router::get('/', 'home');

Router::get('/artists', 'artists');

// function ($args){

// }

// Router::get('/about-us', function ($args){
//     require_once 'resources/views/about.phtml';
// });

// Router::get('/contact-us', function ($args) {
//     require_once 'resources/views/contact.phtml';
// });

Router::get('/404', '404');



Router::run();