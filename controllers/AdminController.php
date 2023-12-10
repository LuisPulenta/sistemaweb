<?php

namespace Controllers;

use MVC\Router;
 
  class AdminController{

    //--------------------------------------------------------------------------------------
    public static function index(Router $router){
      
    if(!is_admin()){
        header('Location:/');
    }

     $router->render('admin/dashboard/index',[
      'titulo'=>'Menú Administrador',
     ]);
    } 
  }
?>
