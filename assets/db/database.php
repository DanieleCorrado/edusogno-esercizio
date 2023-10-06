<?php

 $host = "localhost";
 $dbname = "edusogno-task";
 $username = "root";
 $password = "root";
    
 
 $mysqli = new mysqli($host, $username, $password, $dbname);


if ($mysqli->connect_errno) {
    die ("Connection error: " . $mysqli->connect_errno);
}

 return $mysqli;