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
        <title>SAVE gestión Pedidos</title>
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
                            <li class="nav-item"><a class="nav-link" href="pedidos.php">Volver</a></li>
                            <li class="nav-item"><a class="nav-link" href="salir.php">Salir</a></li>
                        </ul>
                    </div >
                    <div id="sesionInfo" class="collapse navbar-collapse panel-footer justify-content-end">
                        <span class="bg-info border border-warning rounded fs-3 fw-bolder"><?php echo $_SESSION['usuario'] ?></span>
                    </div>
                </div>
            </nav> 

            <h1>Pedido nuevo</h1>
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-group">
                            <label for="tienda" class="col-4 col-form-label">Tienda:</label>
                            <div class="col-6">
                                <select class="form-select " id="tienda">
                                    <!-- se rellena con AJAX -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="tienda" class="col-4 col-form-label">Tienda:</label>
                            <div class="col-6">
                                <select class="form-select " id="origen">

                                    <option value="1">Elegir origen</option>
                                    <option value="2">Company 2</option>
                                    <option value="3">Company 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover" id="referencias">
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

            <!-- Formulario para agregar referencia -->
            <div class="modal fade" id="formularioReferencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header bg-info bg-gradient d-flex justify-content-between align-items-center">
                            <h3 class="modal-title" style="text-align: center;" id="cabecera">
                                Nueva Referencia
                            </h3>
                            <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal" ><i class="bi bi-x-square"></i></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Referencia:</label>
                                    <input type="text" id="referencia" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Etiqueta:</label>
                                    <input type="text" id="etiqueta" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Unidades:</label>
                                    <input type="text" id="unidades" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-check">
                                    <input type="checkbox" id="enTienda" class="form-check-input" placeholder="">
                                    <label class="form-check-label" for="enTienda">En tienda:</label>
                                </div>
                            </div> 
                            <div class="form-row">
                                 <div class="form-check">
                                    <input type="checkbox" id="fianza" class="form-check-input" placeholder="">
                                    <label class="form-check-label" for="fianza">En tienda:</label>
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
                dom:"lrtip",

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
                        defaultContent:
                            '<div class="action-buttons">' +
                                '<span class="edit"><i class="bi bi-pencil"></i></span> ' +
                                '<span class="remove"><i class="bi bi-trash"></i></span> ' +
                                '<span class="cancel"></span>' +
                            '</div>',
                        className: 'row-edit dt-center',
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
                    }
                   /* {
                    targets: 6,
                    defaultContent:
                    '<div className="space-x-2">' +
                    '<button class="btn btn-sm btn-primary botonModificar"><i class="bi bi-pencil"></i></buuton>' +
                    '<button class="btn btn-sm btn-danger botonBorrar"><i class="bi bi-trash-fill"></i></buuton>' +
                    '</div>',
                    className: 'row-edit dt-center',
                    orderable: false,
                    data: null
                    width:"5%"
                    }*/],
                language:
                {
                    "url": "../js/spanish.json",
                }       
            });

        
        // Eventos que interactuan con el formulario de entrada

        function formularioReferencia()
            {
                $("#confirmarAgregar").show();
                $("#confirmarModificar").hide();
                limpiarFormulario();
                document.getElementById("cabecera").innerText = "Nueva referencia";
                $("#formularioReferencia").modal('show');
            }
        
        function limpiarFormulario()
            {
                $('#referencia').val('');
                $('#unidades').val('');
                $('#etiqueta').val ('');
                $('enTienda').removeAttr("checked");
                $('#deposito').removeAttr("checked");
                $('#comentarios').val('');
            } 

        
        $('#confirmarAgregar').click(function()
            {
                let registro = recuperarDatosFormulario();
                if(registro.referencia == '')
                   {
                    alert ("La referencia no puede estar vacia");
                    return;
                   }
                if(registro.etiqueta == '')
                   {
                    alert ("La Etiqueta no puede estar vacia");
                    return;
                   } 
                if(registro.unidades == '')
                    {
                    alert ("Las unidades no puede estar vacias");
                    return;
                    } 
                
                $("#formularioReferencia").modal('hide');
                agregarRegistro(registro);
            });

        $('#confirmarModificar').click(function()
            {
                $("#formularioReferencia").modal('hide');
                let registro = recuperarDatosFormulario();
                modificarReferencia(registro);   
            });  

        $('#referencias tbody').on('click',"button.botonBorrar", function()
            {
                table
                .row($(this).parents('tr'))
                .remove()
                .draw();
            });

        $('#referencias tbody').on('click',"button.botonModificar", function()
            {
                $("#confirmarAgregar").hide();
                $("#confirmarModificar").show();
                let registro = tabla2.row($(this).parents('tr')).data();
                document.getElementById("cabecera").innerText = "Modificar referencia";
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
        
        function listarTiendas()
        {
            $.ajax(
                {
                    type: "GET",
                    url: "datosPedidos.php?accion=listarTiendas,
                    data: '',
                    success: function(datos)
                   {
                        var len = datos.length:
                        for (var i=0;i<len; i++)
                        {
                            $('#tienda').append('<option value="'+ datos[i].idTienda + '">') + datos[i].tienda + '</optio>');
                        }
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
