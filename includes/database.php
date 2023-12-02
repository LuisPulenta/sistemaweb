<?php

$serverName = "keypress.serveftp.net";
$connectionInfo = array( "Database"=>"LuisSistemaWeb", "UID"=>"sa", "PWD"=>"kp97cba$22","CharacterSet" => "UTF-8");
$db = new PDO("sqlsrv:server=$serverName;database=LuisSistemaWeb", "sa", "kp97cba$22");


if(!$db) {
    echo "Error no se pudo conectar";
    exit;        
}

?>