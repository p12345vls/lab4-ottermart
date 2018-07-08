<?php

function getDatabaseConnection($dbname = 'ottermart') {
    $host = 'localhost';
    //$dbname = 'tcp';
    $username = 'root';
    $password = '';
    
    //creates new connection
    $dbConn = new PDO("mysql:host=$host; dbname=$dbname",$username,$password);
    //display errors when accessing tables
    $dbConn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}

?>