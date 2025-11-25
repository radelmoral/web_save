<?php
  session_start();
    if (($_SESSION['rol'] < 1 OR $_SESSION['rol'] > 4))
     {
        session_destroy();
        header('location: ../index.php');
    } 

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>SAVE gestión pedidos</title>
        <link rel="icon" type="image/x-icon" href="../img/save.ico">

        <link rel="stylesheet" href="../css/datatables.min-2.3.4.css">
        <link rel="stylesheet" href="../css/buttons.dataTables.min-3.2.5.css">
        <link rel="stylesheet" href="../css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="../css/tabla.css">
        <!--link rel="stylesheet" href="../css/font_awesome.all.min.css" -->
        <link rel="stylesheet" href="../css/bootstrap-icons.min.css">
         <link rel="stylesheet" href="../css/bootstrap.min.css">
      
        <script type="text/javascript" src="../js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <script type="text/javascript" src="../js/datatables.min-2.3.4.js"></script>
        <script type="text/javascript" src="../js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap-session-timeout.js"></script>
        <script type="text/javascript" src="../js/dataTables.buttons.min-3.2.5.js"></script>
        <script type="text/javascript" src="../js/buttons.colVis.min3.2.5.js"></script>
        <script type="text/javascript" src="../js/buttons.html5.min3.2.5.js"></script>
        <script type="text/javascript" src="../js/buttons.print.min-3.2.5.js"></script>
        <script type="text/javascript" src="../js/pdfmake.min-0.2.7.js"></script>
        <script type="text/javascript" src="../js/jszip.min-3.10.1.js"></script>
        <script type="text/javascript" src="../js/vfs_fonts-0.2.7.js"></script>
         <script type="text/javascript" src="../js/bootstrap.min.js"></script>


    </head>
    <body>
        <div class="container">
            <input type="hidden" id="rol_sesion" value="<?php echo $_SESSION['rol']?>"> 
            <!-- barra de navegacion -->
            <nav class="navbar navbar-expand-md" style="background-color: #e3f2fd;">
                <div class="container-fluid">
                    <button type="button" class ="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#MenuNavegacion">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href = "https://www.savestore.es/" target="_blank" class="navbar-brand">
                        <img src="../img/logo-save.svg" alt="..." height="36">
                    </a>
                    <div id="MenuNavegacion" class="collapse navbar-collapse">
                        <ul class="navbar-nav ms-3">
                           <?php
                                if ($_SESSION['rol']==1)
                                {
                                    echo '<li class="nav-item"><a class="nav-link" href="javascript:formularioReferencia();">Añadir referencias</a></li>
                                            <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>';
                                    
                                }
                                elseif ($_SESSION['rol']>=2)
                                {
                                    echo '<li class="nav-item"><a class="nav-link" href="javascript:formularioClave();">Cambiar contraseña</a></li>';
                                }
                                
                                if ($_SESSION['rol']<4)
                                {
                                    echo '<li class="nav-item"><a class="nav-link" href="repuestos.php">Repuestos</a></li>
                                        <li class="nav-item"><a class="nav-link" href="telefonos.php">Teléfonos</a></li>
                                        <li class="nav-item"><a class="nav-link" href="apple.php">Apple Original</a></li>
                                        <li class="nav-item"><a class="nav-link" href="oppo.php">Oppo Original</a></li>';
                                }
                                else
                                    echo '<li class="nav-item"><a class="nav-link" href="apple.php">Apple Original</a></li>';
                            ?>
                            <li class="nav-item"><a class="nav-link" href="salir.php">Salir</a></li> 
                        </ul>
                    </div >
                    <div id="sesionInfo" class="collapse navbar-collapse panel-footer justify-content-end">
                        <span class="bg-info border border-warning rounded fs-3 fw-bolder"><?php echo $_SESSION['usuario'] ?></span>
                    </div>
                </div>
            </nav> 

            <h1>Gestion de pedidos</h1>
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover" id="pedidos">
                    <thead >
                        <tr>
                            <th>Nº</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Tienda</th>
                            <th>Comentarios</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Formulario para agregar pedido nuevo-->
            <div class="modal fade" id="formularioPedidos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
                <div class="modal-dialog modal-lg" style="max-width: 80%;">
                    <div class="modal-content">

                        <div class="modal-header bg-info bg-gradient d-flex justify-content-between align-items-center">
                            <h3 class="modal-title" style="text-align: center;" id="cabecera">
                                Nuevo pedido
                            </h3>
                            <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal" ><i class="bi bi-x-square"></i></button>
                        </div>

                        <div class="modal-body">
                            <div class="container-fluid">   
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="tienda" class="col-4 col-form-label">Tiendas:</label>
                                            <div class="col-6">
                                                <select class="form-control " id="tienda">
                                                    <option value="1">Default</option>
                                                    <option value="2">Company 2</option>
                                                    <option value="3">Company 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="tipo" class="col-4 col-form-label">Tipo:</label>
                                            <div class="col-6"> 
                                                <select class="form-control col-4" id="tipo">
                                                    <option value="1">Default</option>
                                                    <option value="2">Company 2</option>
                                                    <option value="3">Company 3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                                <div class="row ms-2 me-2">
                                    <table class="table table-striped table-bordered table-hover" id="nuevoPedido">
                                        <thead >
                                            <tr>
                                                <th>Referencia</th>
                                                <th>Etiqueta</th>
                                                <th>Uds.</th>
                                                <th>En tienda</th>
                                                <th>Depósito</th>
                                                <th>Comentarios</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                        <div class="modal-footer">
                            <button type="button" id="confirmarAgregar" class="btn btn-success">Agregar</button>
                            <button type="button" id="confirmarModificar" class="btn btn-success">Modificar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div> 
            <!--  Fin formulario pedidos -->

            <!-- Formulario para agregar nueva linea -->
            <div class="modal fade" id="formularioNuevoRepuesto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-info bg-gradient d-flex justify-content-between align-items-center">
                            <h3 class="modal-title" style="text-align: center;" id="cabecera">
                                Usuarios
                            </h3>
                            <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal" ><i class="bi bi-x-square"></i></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Referencia:</label>
                                    <input type="text" id="nombre" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Etiqueta:</label>
                                    <input type="text" id="usuario" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Unidades:</label>
                                    <input type="text" id="email" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Cont raseña:</label>
                                    <input type="text" id="clave" class="form-control" placeholder="">
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Rol:</label>
                                    <input type="number" min="1" max="4" id="rol" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="confirmarAgregar" class="btn btn-success">Agregar</button>
                            <button type="button" id="confirmarModificar" class="btn btn-success">Modificar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>

                </div>
                
            </div> 
            <!--  Fin formulario agregar articulo -->
        </div>

         

        <script>

            $.sessionTimeout
                ({
                    title: 'Cierre automatico de sesión',
                    message: '',
                    countdownSmart: true,
                    countdownMessage: 'Su sesion se cerrara en {timer}',
                    logoutButton: 'Salir',
                    keepAliveButton: 'Continuar',
                    keepAlive: false,
                    logoutUrl: 'salir.php',
                    redirUrl: 'salir.php',
                    warnAfter:  600000,
                    redirAfter: 720000,
                    
                });
       
            let tabla5=$("#pedidos").DataTable
                ({  orderCellsTop:true,
                    fixedHeader: true,
                    //dom:"lrtip",
                    layout:
                    {
                        top1Start:
                        {
                            buttons:[
                            {
                                text:"Nuevo",
                                action: function (e, dt, node, config)
                                    {
                                        dtNuevo();
                                    }
                            }],
                        }
                    },
                    
                    ajax:
                        {
                            url: "datosPedidos.php?accion=listar",
                            dataSrc: "" 
                        },
                    columns:
                    [{data: "idPedido"},
                    {data: "fecha"},
                    {data: "estado"},
                    {data: "idTienda"},
                    {data: "comentarios", 
                     orderable: false,
                     render:function(data, type, row)
                        {
                            return data.length > 20 ? data.substr(0,20) + "...":data;
                        }
                    },
                    {data: null,
                    orderable: false}],
                    
                    columnDefs:
                    [{
                        targets: 0,
                        width:"5%"
                    },
                    {   
                        targets:1,
                        width:"15%"
                    },
                    {   
                        targets:2,
                        width:"10%"   
                    },
                    {   
                        targets:3,
                        width:"15%"   
                    },
                    {
                    targets: 5,
                    defaultContent:'<button class="btn btn-sm btn-primary botonVer"><i class="bi bi-eye-fill"></i></buuton>',
                    className: 'row-edit dt-center',
                    orderable: false,
                    data: null,
                    width:"5%"
                    }],
                    
                    language:
                    {
                        url: "../js/spanish.json",
                    }       
                });   

           let tabla6=$("#nuevoPedido").DataTable
                ({  orderCellsTop:true,
                    fixedHeader: true,
                    autoWidth:true,
                    layout:
                    {
                        top1Start:
                        {
                            buttons:[
                            {
                                text:"Añadir",
                                action: function (e, dt, node, config)
                                    {
                                        dtAñadir();
                                    }
                            }],
                        }
                    },
                    
                   /* ajax:
                        {
                            url: "datosPedidos.php?accion=listar",
                            dataSrc: "" 
                        },*/
                    columns:
                    [{data: "referencia"},
                    {data: "etiqueta"},
                    {data: "unidades"},
                    {data: "enTienda"},
                    {data: "deposito"},
                    {data: "comentarios", 
                     orderable: false,
                     render:function(data, type, row)
                        {
                            return data.length > 20 ? data.substr(0,20) + "...":data;
                        }
                    },
                    {data: null,
                    orderable: false}],
                    
                    columnDefs:
                    [{
                        targets:0,
                        width:"10%"
                    },
                    {   
                        targets:1,
                        width:"10%"
                    },
                    {   
                        targets:2,
                        width:"5%"   
                    },
                    {   
                        targets:3,
                        width:"5%"   
                    },
                    {   
                        targets:4,
                        width:"5%"   
                    },
                    {
                    targets: 6,
                    defaultContent:'<button class="btn btn-sm btn-primary botonVer"><i class="bi bi-eye-fill"></i></buuton>',
                    className: 'row-edit dt-center',
                    orderable: false,
                    data: null,
                    width:"5%"
                    }],
                    
                    language:
                    {
                        url: "../js/spanish.json",
                    }       
                });      

                function dtNuevo()
                    {
                       /* $("#confirmarAgregar").show();
                        $("#confirmarModificar").hide();
                        //limpiarFormulario();
                        //document.getElementById("cabecera").innerText = "Nuevo usuario";
                        $("#formularioPedidos").modal('show');*/
                        location.href="pedidoNuevo.php"
                    }
        </script>

    </body>
</html>
