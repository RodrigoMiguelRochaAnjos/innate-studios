<?php
session_start();

require_once 'core/Application.php';
require_once 'core/Controller.php';
require_once 'core/Router.php';
require_once 'database/Connection.php';
require_once 'database/Query.php';
require_once 'Controllers/HomeController.php';
require_once 'Controllers/MusicController.php';
require_once 'Controllers/ArtistsController.php';
require_once 'Controllers/DashboardController.php';
require_once 'Controllers/DashboardMusicController.php';
require_once 'Controllers/BandsController.php';
require_once 'Controllers/AboutController.php';
require_once 'Controllers/ContactController.php';
require_once 'Controllers/LoginController.php';
require_once 'Models/Member.php';
require_once 'Models/Artist.php';
require_once 'Models/Music.php';
require_once 'Models/Studio.php';
require_once 'Models/Band.php';
require_once 'Models/Album.php';

use app\core\Application;
use app\core\Router;

$app = new Application(__DIR__);

$app->router->get('/', 'home');

$app->router->get('/artists', 'artists');

$app->router->get('/about-us', 'about');

$app->router->get('/contact-us', 'contact');

$app->router->get('/login', 'login');

$app->router->get('/dashboard', 'dashboard');

$app->router->get('/dashboard-music', 'dashboardMusic');

$app->router->get('/music', 'music');

$app->router->get('/bands', 'bands');

$app->router->get('/logout', function () {
    session_unset();
    session_destroy();

    header("Location: /login");
});


$app->run();

