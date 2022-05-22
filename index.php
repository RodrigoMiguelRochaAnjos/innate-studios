<?php
session_start();
require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Controller.php';
require_once 'logic/Controllers/HomeController.php';
require_once 'logic/Controllers/ArtistsController.php';
require_once 'logic/Controllers/DashboardController.php';
require_once 'logic/Controllers/DashboardMusicController.php';
require_once 'logic/Controllers/AboutController.php';
require_once 'logic/Controllers/ContactController.php';
require_once 'logic/Controllers/LoginController.php';
require_once 'logic/Models/Member.php';
require_once 'logic/Models/Artist.php';
require_once 'logic/Models/Music.php';
require_once 'logic/Models/Studio.php';
require_once 'logic/Models/Band.php';
require_once 'logic/Models/Album.php';
require_once 'logic/Router.php';

Router::get('/', 'home');

Router::get('/artists', 'artists');

Router::get('/about-us', 'about');

Router::get('/contact-us', 'contact');

Router::get('/login', 'login');

Router::get('/dashboard', 'dashboard');

Router::get('/dashboard-music', 'dashboardMusic');

Router::get('/music', 'music');

Router::get('/logout', function () {
    session_unset();
    session_destroy();

    header("Location: /login");
});


Router::run();

