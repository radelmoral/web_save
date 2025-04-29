<?php

header('Content-Type: application/json');

require("../conexion.php");

$conexion = devolverConexion();

switch ($_GET['accion']) 
{
    case 'listar':
        $datos = mysqli_query($conexion, "SELECT referencia, categoria , marca, modelo, etiqueta, FORMAT(pvp,2,'es_ES') pvp FROM repuestos");
        $resultado = mysqli_fetch_all($datos,MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;
    
    case 'agregar':
        $respuesta = mysqli_query( $conexion,"INSERT INTO repuestos (referencia, marca, categoria, modelo, etiqueta, pvp) VALUES ('$_POST[referencia]', '$_POST[marca]', '$_POST[categoria]', '$_POST[modelo]' ,'$_POST[etiqueta]', '$_POST[pvp]')");
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;    
   
    case 'borrar':
        $respuesta = mysqli_query($conexion, "DELETE FROM repuestos WHERE referencia='$_GET[referencia]'");
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;

    case 'consultar':
        $datos = mysqli_query($conexion, "SELECT referencia, categoria , marca, modelo, etiqueta, pvp  FROM repuestos WHERE referencia='$_GET[referencia]'");
        $resultado= mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;

    case 'modificar':
        $respuesta = mysqli_query($conexion,"UPDATE repuestos SET categoria = '$_POST[categoria]',
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





//"SELECT referencia, categoria , marca, modelo, etiqueta, precio FROM repuestos where referencia=$_GET[referencia]"

//"INSERT into referencias (referencia, categoria, marca, modelo, etiqueta, precio) values ('$_POST[referencia]', '$_POST[categoria]', '$_POST[marca]', '$_POST[modelo]', '$_POST[etiqueta]', '$_POST[precio]')"

//"DELETE from referencias where referencia=$_GET[referencias]"

//"UPDATE referencias set categoria='$_POST[categoria]',
//                        marca='$_POST[marca]',
//                        modelo='$_POST[modelo]',
//                        etiqueta='$_POST[etiqueta]',
//                        precio='$_POST[precio]'
//                        where referencia=$_GET[referencia]"

?>
 