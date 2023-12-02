<?php

namespace Model;

class Usuario extends ActiveRecord{
    //Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','password','telefono','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $password_actual;
    public $password_nuevo;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this-> id = $args['id'] ?? null;
        $this-> nombre = $args['nombre'] ?? '';
        $this-> apellido = $args['apellido'] ?? '';
        $this-> email = $args['email'] ?? '';
        $this-> password = $args['password'] ?? '';
        $this-> password2 = $args['password2'] ?? '';
        $this-> password_actual = $args['password_actual'] ?? '';
        $this-> password_nuevo = $args['password_nuevo'] ?? '';
        $this-> telefono = $args['telefono'] ?? '';
        $this-> admin = $args['admin'] ?? 0;
        $this-> confirmado = $args['confirmado'] ?? 0;
        $this-> token = $args['token'] ?? '';
    }

    //Mensajes de validación para la creación de una cuenta
    //--------------------------------------------------------------------------------------
    public function validarNuevaCuenta(){
        if(!$this->nombre){
            self::$alertas['error'][]='El Nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][]='El Apellido es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][]='El Email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][]='El Password es obligatorio';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]='El Password debe tener al menos 6 caracteres';
        }
        if($this->password !== $this->password2){
            self::$alertas['error'][]='Los Passwords son diferentes';
        }

        return self::$alertas;
    }

    //Mensajes de validación para el Login
    //--------------------------------------------------------------------------------------
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][]='El Email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        if(!$this->password){
            self::$alertas['error'][]='El Password es obligatorio';
        }
        return self::$alertas;
    }

    //Mensajes de validación de Email
    //--------------------------------------------------------------------------------------
    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]='El Email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no válido';
        }
        return self::$alertas;
    }

    //Mensajes de validación de Password
    //--------------------------------------------------------------------------------------
    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='El Password es obligatorio';
        }
        if(strlen($this->password)<6){
            self::$alertas['error'][]='El Password debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }

    //Revisa si el usuario ya existe
    //--------------------------------------------------------------------------------------
     public function existeUsuario(){
        //Revisar si un usuario existe o no

        $resultado = Usuario::where('email',$this->email);

        if($resultado){
            self::$alertas['error'][] = 'El Usuario ya está registrado';
        }
        return ($resultado) ;
    }

    //Hashear el Password
    //--------------------------------------------------------------------------------------
    public function hashPassword(){
        $this->password = password_hash($this->password,PASSWORD_BCRYPT);
    }

    //Generar Token
    //--------------------------------------------------------------------------------------
    public function crearToken(){
        $this->token = uniqid();
    }
    
    //--------------------------------------------------------------------------------------
    public function comprobarPasswordAndVerificado($password){
        $resultado = password_verify($password,$this->password);

        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][]='Password incorrecto o tu cuenta no ha sido confirmada';
        }else{
            return true;
        };        
    }
}    
?>