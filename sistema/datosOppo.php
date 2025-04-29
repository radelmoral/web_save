<?php

header('Content-Type: application/json');

require("../conexion.php");

$conexion = devolverConexion();

switch ($_GET['accion']) 
{
    case 'listar':
        $datos = mysqli_query($conexion, "SELECT referencia, categoria , marca, modelo, etiqueta, FORMAT(pvp,2,'es_ES') pvp FROM oppo_original");
        $resultado = mysqli_fetch_all($datos,MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;
    
    case 'agregar':
        $respuesta = mysqli_query( $conexion,"INSERT INTO oppo_original (referencia, marca, categoria, modelo, etiqueta, pvp) VALUES ('$_POST[referencia]', '$_POST[marca]', '$_POST[categoria]', '$_POST[modelo]' ,'$_POST[etiqueta]', '$_POST[pvp]')");
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;    
   
    case 'borrar':
        $respuesta = mysqli_query($conexion, "DELETE FROM oppo_original WHERE referencia='$_GET[referencia]'");
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;

    case 'consultar':
        $datos = mysqli_query($conexion, "SELECT referencia, categoria , marca, modelo, etiqueta, pvp  FROM oppo_original WHERE referencia='$_GET[referencia]'");
        $resultado= mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;

    case 'modificar':
        $respuesta = mysqli_query($conexion,"UPDATE oppo_original SET categoria = '$_POST[categoria]',
                                                                    marca = '$_POST[marca]',
                                                                    modelo = '$_POST[modelo]',
                                                                    etiqueta = '$_POST[etiqueta]',
                                                                    pvp = '$_POST[pvp]'
                                                            WHERE referencia = '$_GET[referencia]'");
        
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;   

    default:
        # code...
        break;

}


?>
 