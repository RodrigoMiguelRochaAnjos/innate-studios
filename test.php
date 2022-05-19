<?php

require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Studio.php';
require_once 'logic/Member.php';
require_once 'logic/Artist.php';
require_once 'logic/Music.php';

$name = "Rodrigo";
$age = 21;
$email = "trabalhorodrigoa@gmail.com";
$password = "123";
$date_joined = '';
$token = '';

$member = \Members\Artist::id(3);

$id = 0;
$title = "Music";
$file = "123";
$datePublished = date("Y-m-d H:i:s");

$music = \Studio\Productions\Music::id(1);

$music->changeAuthor($member->id);


// $params = [
//     'name' => "Miguel",
//     'email' => "D4rkmagic@gmail.com",
//     'password' => "123456",
//     'date_joined' => date("Y-m-d H:i:s"),
//     'token' => '123'
// ];

// \Database\Query::update($params, "members", "id = ?", [1]);

// $fields = ["id", "name", "email", "password", "date_joined", "token"];

// $results = \Database\Query::read($fields, "members");
