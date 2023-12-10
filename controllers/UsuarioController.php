<?php

namespace Controllers;

use MVC\Router;
 
  class UsuarioController{

    //--------------------------------------------------------------------------------------
    public static function index(Router $router){
      
      if(!is_auth() || is_admin()){
        header('Location:/');
    }
     $router->render('usuario/dashboard/index',[
      'titulo'=>'Menú Usuario',       
     ]);
    } 
  }
?>
