<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = 'root';
$dbname = 'edusogno';

//Open a connection to MySQL Server
if(!$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)) {
    die("failed to connect!");
}

