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
        $username = $url["user"];
        $password = $url["path"];
    } 

    
    //creates new connection
    $dbConn = new PDO("mysql:host=$host; dbname=$dbname",$username,$password);
    //display errors when accessing tables
    $dbConn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}

?>
