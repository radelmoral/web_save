<?php
    session_start();
    if ($_SESSION['rol'] != 1)
    {
       session_destroy(); 
       header('location: ../index.php');
    } 
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>SAVE gestión usuarios</title>
        <link rel="icon" type="image/x-icon" href="../img/save.ico">

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/datatables.min.css">
        <link rel="stylesheet" href="../css/fixedHeader.dataTables.min.css">
        <link rel="stylesheet" href="../css/tabla.css">
        <!--link rel="stylesheet" href="../css/font_awesome.all.min.css" -->
        <link rel="stylesheet" href="../css/bootstrap-icons.min.css">
     
        <script type="text/javascript" src="../js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <script type="text/javascript" src="../js/datatables.min.js"></script>
        <script type="text/javascript" src="../js/dataTables.fixedHeader.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap-session-timeout.js"></script>


    </head>
    <body>
        <div class="container">
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
                            <li class="nav-item"><a class="nav-link" href="javascript:formularioUsuario();">Añadir usuario</a></li>
                            <li class="nav-item"><a class="nav-link" href="repuestos.php">Repuestos</a></li>
                            <li class="nav-item"><a class="nav-link" href="telefonos.php">Teléfonos</a></li>
                            <li class="nav-item"><a class="nav-link" href="apple.php">Apple Original</a></li>
                            <li class="nav-item"><a class="nav-link" href="oppo.php">Oppo Original</a></li>
                            <li class="nav-item"><a class="nav-link" href="salir.php">Salir</a></li>
                        </ul>
                    </div >
                    <div id="sesionInfo" class="collapse navbar-collapse panel-footer justify-content-end">
                        <span class="bg-info border border-warning rounded fs-3 fw-bolder"><?php echo $_SESSION['usuario'] ?></span>
                    </div>
                </div>
            </nav> 

            <h1>Listado Usuario</h1>
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover" id="usuarios">
                    <thead >
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>email</th>
                            <th>rol</th>
                    <!--    <th>clave</th>  -->
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Formulario para agregar usuarios -->
            <div class="modal fade" id="formularioUsuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
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
                                    <label>Nombre:</label>
                                    <input type="text" id="nombre" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Usuario:</label>
                                    <input type="text" id="usuario" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>email:</label>
                                    <input type="text" id="email" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Contraseña:</label>
                                    <input type="text" id="clave" class="form-control" placeholder="">
                                </div>
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Rol:</label>
                                    <input type="number" id="rol" class="form-control" placeholder="">
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

            $.sessionTimeout({
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

            let tabla2=$("#usuarios").DataTable
            ({  orderCellsTop:true,
                fixedHeader: true,
                "dom":"lrtip",

                "ajax":
                    {
                        url: "datosUsuarios.php?accion=listar",
                        dataSrc: "" 
                    },
                "columns":
                [{"data": "id_usuario", "className": "text-center", "width":"5%"},
                 {"data": "nombre"},
                 {"data": "usuario"},
                {"data": "email"},
                //{"data": "clave"},
                {"data": "rol" },
                {"data": null,"orderable": false}],
                "columnDefs":
                [{
                    targets: 5,
                    "defaultContent":
                    '<div className="space-x-2">' +
                    '<button class="btn btn-sm btn-primary botonModificar"><i class="bi bi-pencil"></i></buuton>' +
                    '<button class="btn btn-sm btn-danger botonBorrar"><i class="bi bi-trash-fill"></i></buuton>' +
                    '</div>',
                    className: 'row-edit dt-center',
                    orderable: false,
                    data: null
                }],
                "language":
                {
                    "url": "../js/spanish.json",
                }       
            });

        
        //Creamos una fila en el head de la tabla y lo clonamos para cada columna
        $('#usuarios thead tr').clone(true).appendTo( '#usuarios thead' );

         $('#usuarios thead tr:eq(1) th').each( function (i) 
        {
            if(i<5)
           { 
                var titulo = $(this).text(); //es el nombre de la columna
                $(this).html( '<input type="text" placeholder="Buscar...'+titulo+'" />' );

                $( 'input', this ).on( 'keyup change', function () 
                {
                    if ( tabla2.column(i).search() !== this.value ) 
                        {
                            tabla2
                            .column(i)
                            .search( this.value )
                            .draw();
                        }
                });
            }     
        });    


                     
        // Eventos que interactuan con el formulario de entrada

        function formularioUsuario()
            {
                $("#confirmarAgregar").show();
                $("#confirmarModificar").hide();
                limpiarFormulario();
                document.getElementById("cabecera").innerText = "Nuevo usuario";
                $("#formularioUsuario").modal('show');
            }
        
        function limpiarFormulario()
            {
                $('#id').val('');
                $('#nombre').val('');
                $('#usuario').val ('');
                $('#email').val('');
                $('#clave').val('');
                $('#rol').val('');
            } 

        
        $('#confirmarAgregar').click(function()
            {
                let registro = recuperarDatosFormulario();
                if(registro.usuario == '')
                   {
                    alert ("El nombre de usuario no puede estar vacio");
                    return;
                   }
                if(registro.clave == '')
                   {
                    alert ("La no puede estar vacia");
                    return;
                   } 
                
                $("#formularioUsuario").modal('hide');
                agregarRegistro(registro);
            });

        $('#confirmarModificar').click(function()
            {
                $("#formularioUsuario").modal('hide');
                let registro = recuperarDatosFormulario();
                modificarUsuario(registro);   
            });  

        $('#usuarios tbody').on('click',"button.botonBorrar", function()
            {
                let registro = tabla2.row($(this).parents('tr')).data();
                let mensaje = 'Seguro que desea eliminar a:\n\n' + registro.nombre ;
                if(confirm(mensaje))
                {
                    
                    borrarRegistro(registro.id_usuario);
                } 

            })

            $('#usuarios tbody').on('click',"button.botonModificar", function()
            {
                $("#confirmarAgregar").hide();
                $("#confirmarModificar").show();
                let registro = tabla2.row($(this).parents('tr')).data();
                document.getElementById("cabecera").innerText = "Modificar usuario";
                recuperarRegistro(registro.id_usuario);
                
            })
        
        
        function recuperarDatosFormulario()
            {
                let registro =
                {
                    id: $('#id').val(), 
                    nombre: $('#nombre').val(),
                    usuario: $('#usuario').val(),
                    email: $('#email').val(),
                    clave: $('#clave').val(),
                    rol: $('#rol').val()
                };
                return registro;
            }
        
        
        function agregarRegistro(registro)
            {
                
                $.ajax(    
                {
                    type: 'POST',
                    url: "datosUsuarios.php?accion=agregar",
                    data: registro,
                    success: function(msg)
                    {
                        tabla2.ajax.reload();
                    },
                    error: function()
                    {
                        alert("Hubo un problema al agregar el registro");
                    }  
                });
            } 
        
        function borrarRegistro(id)
        {
            
            $.ajax(    
            {
                type: 'GET',
                url: "datosUsuarios.php?accion=borrar&id=" + id,
                data: '',
                success: function(msg)
                {
                    tabla2.ajax.reload();
                },
                error: function()
                {
                    alert("Hubo un problema al borrar el registro");
                }  
            });
        }
        
        function recuperarRegistro(id)
        {
            $.ajax(
                {
                    type: "GET",
                    url: "datosUsuarios.php?accion=consultar&id=" + id,
                    data: '',
                    success: function(datos)
                   {
                        $('#id').val(datos[0].id_usuario);
                        $('#nombre').val(datos[0].nombre);
                        $('#usuario').val(datos[0].usuario);
                        $('#email').val(datos[0].email);
                        $('#clave').val('');
                        $('#rol').val(datos[0].rol);
                        
                        $("#formularioUsuario").modal('show');
                   },
                   error: function()
                  {
                        alert("Hubo un error al recuperar los datos");
                  }  
                });
        } 

        function modificarUsuario(registro)
        {
            $.ajax(
                {
                    type: "POST",
                    url: "datosUsuarios.php?accion=modificar&id=" + registro.id,
                    data: registro,
                    success: function(msg)
                       {
                            tabla2.ajax.reload();
                       },
                    error: function()
                      {
                            alert("Hubo un error al modificar el registro"); 
                      } 

                }); 

        } 

        </script>

    </body>
</html>
