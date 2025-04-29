<?php
header('Content-Type: application/json');

require("../conexion.php");
    session_start();
    $conexion = devolverConexion();

    $pass = password_hash(mysqli_real_escape_string ($conexion, $_POST['claveNueva']), PASSWORD_DEFAULT);
    $id_usuario = $_SESSION['id_usuario']; 
    $codigo = '';
    $msg = '';
    $resultado = array(0);
    
    $query = mysqli_query($conexion,"SELECT * FROM usuarios WHERE id_usuario = $id_usuario");
    $datos = mysqli_fetch_array($query);
    $cuentas = mysqli_num_rows($query);
   
    if ($cuentas == 1) 
    {
        if ($_POST['accion'] == 'cambiarClave' )
        {
            if (!empty($_POST['claveActual']) && !empty($_POST['claveNueva'])) 
            {
                if (password_verify($_POST['claveActual'], $datos['clave'])) 
                {
                    $query_update = mysqli_query($conexion,"UPDATE usuarios SET clave = '$pass' WHERE id_usuario = $id_usuario");
                    if ($query_update)
                    {
                        $codigo = 00;
                        $msg = "Contraseña cambiada con éxito";
                    }
                    else {
                        $codigo = 02;
                        $msg = "No se ha podico cambiar la contraseña";
                    }
                }
                else
                {
                    $codigo = 01;
                    $msg = "La contraseña actual es incorrecta";    
                }
            }
            else
            {
                $codigo = 03;
                $msg ="Debe proporcionar contraseña actual y nueva";    
            }
        }
        else
        {
            $codigo = 05;
            $msg = "Acción no permitida";  
        }
    }
    else
    {
        $codigo = 04;
        $msg = "No hay cuenta para el usuario de la sesión";
    }
    mysqli_close($conexion);  
    $resultado = array('codigo' => $codigo, 'msg' => $msg);
    echo json_encode($resultado);

?>