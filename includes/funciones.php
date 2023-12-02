<?php

// Debuguear
//--------------------------------------------------------------------
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
//--------------------------------------------------------------------
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Función que revisa que el usuario está autenticado
//--------------------------------------------------------------------
function isAuth(): void {
    if(!isset($_SESSION['login'])){
     header('Location:/');
    }
 }

//Función que revisa si hay sesión abierta y si no la abre
//--------------------------------------------------------------------
function isSession(): void {
    if(!isset($_SESSION)){
     session_start();
    }
 }