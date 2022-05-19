<?php

require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Studio.php';
require_once 'logic/Member.php';
require_once 'logic/Artist.php';

$name = "Rodrigo";
$age = 21;
$email = "trabalhorodrigoa@gmail.com";
$password = "123";
$date_joined = '';
$token = '';

$member = \Members\Artist::params($name, $age, $email, $password, $date_joined = '', $token = '');


$member_1 = \Members\Artist::id(5);

echo $member_1->email;


// $params = [
//     'name' => "Rodrigo",
//     'email' => "trabalhorodrigoa@gmail.com",
//     'password' => "123",
//     'date_joined' => "NOW()",
//     'token' => '123'
// ];

// \Database\Query::create($params, "members");

// $fields = ["id", "name", "email", "password", "date_joined", "token"];

// $results = \Database\Query::read($fields, "members");

