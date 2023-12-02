<?php

namespace Controllers;

use MVC\Router;
 
  class UsuarioController{

    //--------------------------------------------------------------------------------------
    public static function index(Router $router){
      
     $router->render('usuario/index',[
      'titulo'=>'Menú Usuario',       
     ]);
    } 
  }
?>
