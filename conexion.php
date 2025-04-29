<?php
function devolverConexion()
{
    $server="localhost:3306";
    $usuario="save";
    $clave="46M1!!Jo57wU.aai";
    $base="Repuestos";

    $conexion = mysqli_connect($server,$usuario,$clave,$base);  
    mysqli_set_charset($conexion,'utf8');
    return $conexion;
}

?>