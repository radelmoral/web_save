<?php
    $aviso= '';

    session_start();

    if (!empty($_SESSION['active']))
   {
      //header('location: index.php');
      session_destroy();
   } 
   else
  { 
    if (!empty($_POST))
   {
        if (empty($_POST['usuario'])|| empty($_POST['password']))
       {
         $aviso = 'Ponga usuario y contraseña';
       } 
       else
      {
        require("conexion.php");
        $conexion = devolverConexion();
 
        $user = mysqli_real_escape_string ($conexion, $_POST['usuario']);
        $pass = mysqli_real_escape_string ($conexion, $_POST['password']);  

        $query = mysqli_query($conexion,"SELECT * FROM usuarios WHERE usuario ='$user'");
        $datos = mysqli_fetch_array($query);
        mysqli_close($conexion);
        
        if (password_verify($pass,$datos['clave'] ))
       {
          $_SESSION['active'] = true;
          $_SESSION['id_usuario'] = $datos['id_usuario'];
          $_SESSION['usuario'] = $datos['usuario'];
          $_SESSION['rol'] = $datos['rol'];

          header('location: ./sistema/repuestos.php');
       } 
        else
       {
          $aviso = 'El usuario o la clave no son correctos';
          session_destroy();
       } 
      } 
   } 
  } 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAVE repuestos</title>
    <link rel="icon" type="image/x-icon" href="img/save.ico">

    <link rel="stylesheet" href="css/bootstrap.min.css">  
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/login.css">


    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/datatables.min.js"></script>
  </head>
  <body>
  <div class="container-fluid ps-md-0">
  <div class="row g-0">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4">Consulta de repuestos SAVE</h3>

              <!-- Sign In Form -->
              <form action="" method="post">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario" autofocus>
                  <label for="usuario">Usuario</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="contraseña" >
                  <label for="password">Contraseña</label>
                </div> 
                <div class = "aviso"><?php echo isset($aviso)? $aviso : ''; ?></div>                
                <div class="d-grid">
                  <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Login</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</html>