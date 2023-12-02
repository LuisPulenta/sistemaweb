<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    //-----------------------------------------------------------------
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    //-----------------------------------------------------------------
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    //-----------------------------------------------------------------
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    //-----------------------------------------------------------------
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    //-----------------------------------------------------------------
    public static function consultarSQL($query){
        //Consultar la BD
            //Lo preparamos
            $stmt = self::$db->prepare($query);
            //Lo ejecutamos        
            $stmt->execute();
            //Obtener los resultados
            $resultado = $stmt->fetchAll();

        // Iterar los resultados
            $array =[];

            foreach($resultado as $registro):
                $array[] = static::crearObjeto($registro);
            endforeach;

        //Liberar la memoria
            //$resultado->free();

        //Retornar los resultados
            return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    //-----------------------------------------------------------------
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    //-----------------------------------------------------------------
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    //-----------------------------------------------------------------
    public function sanitizarAtributos(){
        $atributos=$this->atributos();
        $sanitizado=[];
        foreach($atributos as $key => $value){
            $sanitizado[$key]=self::$db->quote($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    //-----------------------------------------------------------------
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    //-----------------------------------------------------------------
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }    

    // Todas las filas
    //-----------------------------------------------------------------
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    //-----------------------------------------------------------------
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Retornar los registros por un orden
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    //-----------------------------------------------------------------
    public static function get($limite) {
        $query = "SELECT TOP(" .$ {limite} . ") * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // crea un nuevo registro
    //-----------------------------------------------------------------
    public function crear(){
         
        //Sanitizar atributos
        $atributos = $this->sanitizarAtributos();

        $stringKeys = join(', ', array_keys($atributos));
        $stringValues = join(", ", array_values($atributos));
      
        //Insertar en la BD
         $query ="INSERT INTO " .  static::$tabla . "( " . $stringKeys ." ) VALUES ( " . $stringValues  . " );";

        //Lo preparamos
         $stmt = self::$db->prepare($query);

         //Lo ejecutamos
         $resultado =$stmt->execute();

         return [
            'resultado' =>  $resultado,
         ];
    }

    // Actualizar el registro
    //-----------------------------------------------------------------
    public function actualizar(){
         
        //Sanitizar atributos
        $atributos = $this->sanitizarAtributos();

        $valores=[];
        foreach($atributos as $key => $value){
            $valores[]="{$key}={$value}";
        }
        
        //Insertar en la BD
        $query ="UPDATE TOP (1) " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id= " . self::$db->quote($this->id);

        //Lo preparamos
        $stmt = self::$db->prepare($query);

        //Lo ejecutamos
        $resultado =$stmt->execute();
        
        return $resultado;       
    }

    // Eliminar un Registro por su ID
    //-----------------------------------------------------------------
    public function eliminar(){
        $query ="DELETE TOP (1) FROM " . static::$tabla . " WHERE id=" .self::$db->quote($this->id) .";";

         //Lo preparamos
         $stmt = self::$db->prepare($query);

         //Lo ejecutamos
         $resultado =$stmt->execute();
         
         if($resultado){
            $this->borrarImagen();
            header('location: /');
        }
    }

}