<?php

$serverName =  $_ENV['DB_HOST'];
$nameDataBase =$_ENV['DB_NAME'];

$connectionInfo = array( "Database"=>$_ENV['DB_NAME'], "UID"=>$_ENV['DB_USER'], "PWD"=>$_ENV['DB_PASS'],"CharacterSet" => "UTF-8");

$db = new PDO("sqlsrv:server=$serverName;database=$nameDataBase", $_ENV['DB_USER'], $_ENV['DB_PASS']);


if(!$db) {
    echo "Error no se pudo conectar";
    exit;        
}

?>