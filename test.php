<?php

require_once 'logic/database/Connection.php';
require_once 'logic/database/Query.php';
require_once 'logic/Studio.php';
require_once 'logic/Member.php';

$name = "Rodrigo";
$age = 21;
$email = "trabalhorodrigoa@gmail.com";
$password = "123";
$date_joined = '';
$token = '';

$member = \Members\Member::params($name, $age, $email, $password, $date_joined = '', $token = '');

echo $member->name;


$params = [
    'name' => "Rodrigo",
    'email' => "trabalhorodrigoa@gmail.com",
    'password' => "123",
    'date_joined' => "NOW()",
    'token' => '123'
];

\Database\Query::create($params, "members");