<?php
require("classes/conn.class.php");
require("classes/validaciones.inc.php");

class Estudiante{
    public $id_estudiante;
    public $fecha_nacimiento;
    public $estado_registro;
    public $id_genero;
    public $conexion;
    public $validacion;

    public function __construct(){
        // conexion heredará de la clase DB
        $this->conexion = new DB();
        // instancia de la clase Validaciones
        $this->validacion = new Validaciones();
    }

    // Setter. Único para cada variable
    public function setIdEstudiante($id_estudiante){
        $this->id_estudiante = $id_estudiante;
    }

    // Getter. Único para cada variable
    public function getIdEstudiante(){
        return $this->id_estudiante;
    }

    public function setFechaNacimiento($fecha_nacimiento){
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    public function getFechaNacimiento(){
        return $this->fecha_nacimiento;
    }

    public function setEstadoRegistro($estado_registro){
        $this->estado_registro = $estado_registro;
    }

    public function getEstadoRegistro(){
        return $this->estado_registro;
    }

    public function setIdGenero($id_genero){
        $this->id_genero = $id_genero;
    }

    public function getIdGenero(){
        return $this->id_genero;
    }

    // Método para obtener todos los estudiantes
    public function obtenerEstudiantes(){
        $resultado = $this->conexion->run('SELECT * FROM estudiante;');
        $array = array("mensaje"=>"Registros encontrados", "data"=>$resultado);
        return $array;
    }

    // Método para obtener un estudiante
    public function obtenerEstudiante(int $id_estudiante){
        if($id_estudiante > 0){
            $resultado = $this->conexion->run('SELECT * FROM estudiante WHERE id_estudiante='.$id_estudiante);
            $array = array("mensaje"=>"Registro encontrado", "data"=>$resultado->fetch());
            return $array;
        }
        else{
            $array = array("mensaje"=>"Registros no encontrados", "data"=>"");
            return $array;
        }
    }

    public function nuevoEstudiante($fecha_nacimiento, $id_genero){
        if(!empty($id_genero) && !empty($fecha_nacimiento)){
            $parametros = array(
                "fecha_nac" => $fecha_nacimiento,
                "id_genero" => $id_genero
            );

            $resultado = $this->conexion->run('INSERT INTO estudiante (fecha_nacimiento_estudiante, id_genero) 
                                                    VALUES (:fecha_nac, :id_genero);', $parametros);

            if($this->conexion->n>0 and $this->conexion->id > 0){
                $resultado = $this->obtenerEstudiantes($this->conexion->id);
                $array = array("mensaje"=>"Registros encontrados", "data"=>$resultado["data"]);
                return $array;
            }
            else {
                $array = array("mensaje"=>"Error al insertar el registro", "data"=>"");
                return $array;
            }
        }
        else {
            $array = array("mensaje"=>"Parámetros enviados vacíos", "data"=>"");
            return $array;
        }
    }
}
