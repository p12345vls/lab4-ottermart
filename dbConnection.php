<?php

function getDatabaseConnection($dbname = 'ottermart') {
    $host = 'localhost';
    //$dbname = 'tcp';
    $username = 'root';
    $password = '';
    
     //when connecting from Heroku
    if  (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
        $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
        $host = $url["host"];
        $dbname = substr($url["path"], 1);
        $username = $url["bcc0fb604c5fe6"];
        $password = $url["3451c4e0"];
    } 

    
    //creates new connection
    $dbConn = new PDO("mysql:host=$host; dbname=$dbname",$username,$password);
    //display errors when accessing tables
    $dbConn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}

?>