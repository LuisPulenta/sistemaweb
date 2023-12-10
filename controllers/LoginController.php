<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;
use Intervention\Image\ImageManagerStatic as Image;
  
  class LoginController{

    //--------------------------------------------------------------------------------------
    public static function login(Router $router){
      //Alertas vacías
   $alertas = [];
   $auth = new Usuario; 
     
   if($_SERVER['REQUEST_METHOD'] ==='POST' ) {
     
     $auth = new Usuario($_POST); 
     $alertas = $auth->validarLogin();

     if(empty($alertas)){
       //Comprobar que exista el Usuario
       $usuario = Usuario::where('email',$auth->email);
       
       if($usuario){
         if($usuario->comprobarPasswordAndVerificado($auth->password)){
           //Autenticar al Usuario
           session_start();
           $_SESSION['id']=$usuario->id;
           $_SESSION['nombre']=$usuario->nombre." ".$usuario->apellido;
           $_SESSION['email']=$usuario->email;
           $_SESSION['login']=true;

           //Redireccionamiento
           if($usuario->admin==="1"){
             $_SESSION['admin']=$usuario->admin ?? null;
             header('Location: /admin/dashboard');
           }else{
            $_SESSION['admin']=$usuario->admin ?? null;
             header('Location: /usuario/dashboard');
           }
           
         };
       } else {
         Usuario::setAlerta('error', 'Usuario no encontrado');
       }
     }

   }else{

   }
     $alertas=Usuario::getAlertas();
     $router->render('auth/login',[
       'alertas' =>$alertas,
       'auth' => $auth
     ]);
 }

    //--------------------------------------------------------------------------------------
    public static function crear(Router $router){
      
      $usuario = new Usuario(); 

      //Alertas vacías
      $alertas = [];

      if($_SERVER['REQUEST_METHOD'] ==='POST' ) {

         // Leer imagen
         if(!empty($_FILES['imagen']['tmp_name'])) {
                
          $carpeta_imagenes = '../public/img/usuarios';

          // Crear la carpeta si no existe
          if(!is_dir($carpeta_imagenes)) {
              mkdir($carpeta_imagenes, 0755, true);
          }

          $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
          $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

          $nombre_imagen = md5( uniqid( rand(), true) );

          $_POST['imagen'] = $nombre_imagen;
      } 

        $usuario->sincronizar($_POST);
        $alertas = $usuario->validarNuevaCuenta();


        //Revisar que alertas esté vacío
        if(empty($alertas)){
          //Verificar que el usuario no esté registrado
          $resultado = $usuario->existeUsuario();
          
          if($resultado){
            $alertas = Usuario::getAlertas();
          }else{
          //Hashear el Password
          $usuario->hashPassword();

          //Eliminar Password2
          unset($usuario->password2);

          //Generar Token único
          $usuario->crearToken();

          // Guardar las imagenes
          $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png" );
          $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp" );

          //Enviar el email
          $email = new Email( $usuario->email,$usuario->nombre,$usuario->token);
          $email->enviarConfirmacion();

          //Crear el Usuario

          $resultado=$usuario->guardar();

          if($resultado){
            header('Location:/mensaje');
          }
        }
      }
    }

      $router->render('auth/crear',[
        'usuario' =>$usuario,
        'alertas' =>$alertas
      ]);
    }

    //--------------------------------------------------------------------------------------
    public static function olvide(Router $router){
      //Alertas vacías
      $alertas = [];

      if($_SERVER['REQUEST_METHOD'] ==='POST' ) {
        $auth = new Usuario($_POST); 
        $alertas = $auth->validarEmail();
        if(empty($alertas)){
          //Comprobar que exista el Usuario
          $usuario = Usuario::where('email',$auth->email);

          if($usuario && $usuario->confirmado==="1"){
            
          //Generar Token único
          $usuario->crearToken();
          $usuario->guardar();

          //Enviar el email
          $email = new Email( $usuario->email,$usuario->nombre,$usuario->token);
          $email->enviarInstrucciones();

          Usuario::setAlerta('exito', 'Revisa tu email');
          }else{
            Usuario::setAlerta('error', 'El Usuario no existe o no está confirmado');
          }
        }
      }
      $alertas = Usuario::getAlertas();
      $router->render('auth/olvide',[
        'alertas' =>$alertas        
      ]);
    }
    //--------------------------------------------------------------------------------------
    public static function confirmar(Router $router){
      $alertas=[];

      $token=s($_GET['token']);

      $usuario = Usuario::where('token',$token);

      if(empty($usuario)){
        //Mostrar mensaje de error
        Usuario::setAlerta('error','Token no válido');

      }else{
        //Modificar usuario confirmado
        $usuario->confirmado = "1";
        $usuario->token = '';
        $resultado = $usuario->guardar();
       
        Usuario::setAlerta('exito','Cuenta comprobada correctamente');
        
      }
      
      //Obtener alertas
      $alertas=Usuario::getAlertas();

      //Renderizar la vista
      $router->render('auth/confirmar',[
        'alertas' => $alertas
      ]);
    }

    //--------------------------------------------------------------------------------------
    public static function mensaje(Router $router){
      $router->render('auth/mensaje');
    }

   
    //--------------------------------------------------------------------------------------
    public static function recuperar(Router $router){

      $alertas=[];
      $error=false;

      $token=s($_GET['token']);

      $usuario = Usuario::where('token',$token);

      if(empty($usuario)){
        //Mostrar mensaje de error
        Usuario::setAlerta('error','Token no válido');
        $error=true;
      }

      if($_SERVER['REQUEST_METHOD'] ==='POST' ) {
        //Leer el nuevo Password y guardarlo

        $password = new Usuario($_POST); 
        $alertas = $password->validarPassword();
        if(empty($alertas)){
          $usuario->password=null;
          $usuario->password=$password->password;
          $usuario->hashPassword();
          $usuario->token = null;
          $resultado = $usuario->guardar();
          if($resultado){
            header('Location:/');
          }
        }
      }
      
      //Obtener alertas
      $alertas=Usuario::getAlertas();

      //Renderizar la vista
      
      $router->render('auth/recuperar',[
        'alertas' =>$alertas,
        'error'=>$error
      ]);
    }

    //--------------------------------------------------------------------------------------
    public static function logout(){
      
      if($_SERVER['REQUEST_METHOD'] ==='POST' ) {
        isSession();
        $_SESSION=[];
        header('Location: /');
      }
      
    }
  }
?>