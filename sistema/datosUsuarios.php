<?php

header('Content-Type: application/json');

require("../conexion.php");

$conexion = devolverConexion();

switch ($_GET['accion']) 
{
    case 'listar':
        $datos = mysqli_query($conexion, "SELECT id_usuario, nombre, usuario, email, rol FROM usuarios");
        $resultado = mysqli_fetch_all($datos,MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;
    
    case 'agregar':
        $password=password_hash($_POST['clave'],PASSWORD_DEFAULT);
        $respuesta = mysqli_query($conexion,"INSERT INTO usuarios (nombre, usuario, email, clave, rol) VALUES ('$_POST[nombre]', '$_POST[usuario]', '$_POST[email]', '$password' ,'$_POST[rol]')");
        echo json_encode($respuesta);
        break;    
   
    case 'borrar':
        $respuesta = mysqli_query($conexion, "DELETE FROM usuarios WHERE id_usuario=$_GET[id]");
        echo json_encode($respuesta);
        mysqli_close($conexion);
        break;

    case 'consultar':
        $datos = mysqli_query($conexion, "SELECT id_usuario, nombre, usuario, email, clave, rol FROM usuarios WHERE id_usuario=$_GET[id]");
        $resultado= mysqli_fetch_all($datos, MYSQLI_ASSOC);
        echo json_encode($resultado);
        mysqli_close($conexion);
        break;

    case 'modificar':
        if ($_POST['clave']=="")
       { 
        $respuesta = mysqli_query($conexion,"UPDATE usuarios SET nombre = '$_POST[nombre]',
                                                                 usuario = '$_POST[usuario]',
                                                                 email = '$_POST[email]',
                                                                 rol = '$_POST[rol]'
                                                            WHERE id_usuario=$_GET[id]");
                                                                
       }
       else
       {
        $password = password_hash($_POST['clave'],PASSWORD_DEFAULT );
        $respuesta = mysqli_query($conexion,"UPDATE usuarios SET nombre = '$_POST[nombre]',
                                                                 usuario = '$_POST[usuario]',
                                                                 email = '$_POST[email]',
                                                                 clave = '$password',
                                                                 rol = '$_POST[rol]'
                                                            WHERE id_usuario=$_GET[id]");
        
       }  
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
 