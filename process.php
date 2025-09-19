<?php
require("classes/estudiante.class.php");

$Estudiante = new Estudiante();

$resultado = $Estudiante->obtenerEstudiantes();

// Retornamos el resultado en formato JSON
header("Content-Type: Application/json");
echo(json_encode($resultado));