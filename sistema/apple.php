<?php
  session_start();
    if (($_SESSION['rol'] < 1 OR $_SESSION['rol'] > 3))
     {
        session_destroy();
        header('location: ../index.php');
    } 

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>SAVE gestión artículos</title>
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
                             
                            ?>
                            <li class="nav-item"><a class="nav-link" href="repuestos.php">Repuestos</a></li> 
                            <li class="nav-item"><a class="nav-link" href="telefonos.php">Teléfonos</a></li>
                            <li class="nav-item"><a class="nav-link" href="oppo.php">Oppo Original</a></li>
                            <li class="nav-item"><a class="nav-link" href="salir.php">Salir</a></li>
                        </ul>
                    </div >
                    <div id="sesionInfo" class="collapse navbar-collapse panel-footer justify-content-end">
                        <span class="bg-info border border-warning rounded fs-3 fw-bolder"><?php echo $_SESSION['usuario'] ?></span>
                    </div>
                </div>
            </nav> 

            <h1>Listado Apple Original</h1>
            <div class="col-12">
                <table class="table table-striped table-bordered table-hover" id="repuestos">
                    <thead >
                        <tr>
                            <th>Referencia</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Etiqueta</th>
                            <th>PVP</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Formulario para agregar articulos -->
            <div class="modal fade" id="formularioRepuesto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info bg-gradient d-flex justify-content-between align-items-center">
                            <h3 class="modal-title" style="text-align: center;" id="cabecera">
                                Referencia
                            </h3>
                            <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal" ><i class="bi bi-x-square"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Referencia:</label>
                                    <input type="text" id="referencia" name="referencia" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Categoria:</label>
                                    <input type="text" id="categoria" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Marca:</label>
                                    <input type="text" id="marca" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Modelo:</label>
                                    <input type="text" id="modelo" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Etiqueta:</label>
                                    <input type="text" id="etiqueta" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>P.V.P.:</label>
                                    <input step="0.01" min="0" type="number"  id="pvp" name="pvp" class="form-control" placeholder="">
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
            
            <!--  formulario cambio de clave  -->
            <div class="modal fade" id="formularioClave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-info bg-gradient d-flex justify-content-between align-items-center">
                            <h3 class="modal-title" style="text-align: center;">
                                Cambio de contraseña
                            </h3>
                            <button type="button" class="btn btn-sm btn-danger float-right" data-bs-dismiss="modal" ><i class="bi bi-x-square"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Contraseña antigua:</label>
                                    <input type="password" id="claveActual" name="claveActual" class="form-control" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Contraseña nueva:</label>
                                    <input type="password" id="claveNueva" class="form-control claveCambio" placeholder="" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Confirmar contraseña nueva:</label>
                                    <input type="password" id="claveRepetida" class="form-control claveCambio" placeholder="" required>
                                </div>
                            </div>
                            <div class="mensajeAlerta" style="display:none; text-align:center; font-weight:bold;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="confirmarCambiar" class="btn btn-success">Cambiar</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </div>

                </div>
            </div> 

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

            let tabla1=$("#repuestos").DataTable
            ({  orderCellsTop:true,
                fixedHeader: true,
                "dom":"lrtip",

                "ajax":
                    {
                        url: "datosApple.php?accion=listar",
                        dataSrc: "" 
                    },
                "columns":
                [{"data": "referencia"},
                 {"data": "categoria"},
                {"data": "marca"},
                {"data": "modelo"},
                {"data": "etiqueta" },
                {"data": "pvp", "width": "5%",
                 render: function (data,type,row)
                    {
                        return data + ' €';
                    } 
                },
                {"data": null,"orderable": false}],
                "columnDefs":
                [{
                    targets: 6,
                    "defaultContent": ($('#rol_sesion').val()==1) ? //solo los administradores les salen los botones
                    '<div className="space-x-2">' +
                    //'<button class="btn btn-sm btn-primary botonModificar"><i class="fa-solid fa-pencil"></i></buuton>' +
                    //'<button class="btn btn-sm btn-danger botonBorrar"><i class="fa-solid fa-trash-can"></i></buuton>' +
                    '<button class="btn btn-sm btn-primary botonModificar"><i class="bi bi-pencil"></i></buuton>' +
                    '<button class="btn btn-sm btn-danger botonBorrar"><i class="bi bi-trash-fill"></i></buuton>' +
                    '</div>' : '',
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
        $('#repuestos thead tr').clone(true).appendTo( '#repuestos thead' );

        $('#repuestos thead tr:eq(1) th').each( function (i) 
        {
            if(i<6)
           { 
                var titulo = $(this).text(); //es el nombre de la columna
                $(this).html( '<input type="text" placeholder="Buscar...'+titulo+'" />' );

                $( 'input', this ).on( 'keyup change', function () 
                {
                    if ( tabla1.column(i).search() !== this.value ) 
                        {
                            tabla1
                            .column(i)
                            .search( this.value )
                            .draw();
                        }
                });
            }     
        });   


            // Eventos que interactuan con el formulario de entrada

        
            function formularioReferencia()
                {
                    $("#confirmarAgregar").show();
                    $("#confirmarModificar").hide();
                    limpiarFormulario();
                    
                    document.getElementById("cabecera").innerText = "Nueva referencia";
                    document.getElementById("referencia").disabled = false;
                    document.getElementById("marca").disabled = true;
                                
                    pvp.value=0;
                    marca.value='Apple';
                    $("#formularioRepuesto").modal('show');
                }
        
            function limpiarFormulario()
                {
                    $('#referencia').val('');
                    $('#categoria').val ('');
                    $('#marca').val('');
                    $('#modelo').val('');
                    $('#etiqueta').val('');
                    $('#pvp').val('');
                }

            function recuperarDatosFormulario()
                {
                    let registro =
                    {
                        referencia: $('#referencia').val(), 
                        categoria: $('#categoria').val(),
                        marca: $('#marca').val(),
                        modelo: $('#modelo').val(),
                        etiqueta: $('#etiqueta').val(),
                        pvp: $('#pvp').val()
                    };
                    return registro;
                }


            function agregarRegistro(registro)
                {
                    
                    $.ajax(    
                    {
                        type: 'POST',
                        url: "datosApple.php?accion=agregar",
                        data: registro,
                        success: function(msg)
                        {
                            tabla1.ajax.reload();
                        },
                        error: function()
                        {
                            alert("Hubo un problema al agregar el registro");
                        }  
                    });
                } 

            function borrarRegistro(referencia)
                {
                    
                    $.ajax(    
                    {
                        type: 'GET',
                        url: "datosApple.php?accion=borrar&referencia=" + referencia,
                        data: '',
                        success: function(msg)
                        {
                            tabla1.ajax.reload();
                        },
                        error: function()
                        {
                            alert("Hubo un problema al borrar el registro");
                        }  
                    });
                }

            function recuperarRegistro(referencia)
                {
                    $.ajax(
                        {
                            type: "GET",
                            url: "datosApple.php?accion=consultar&referencia="+referencia,
                            data: '',
                            success: function(datos)
                            {
                                console.log(datos);
                                $('#referencia').val(datos[0].referencia);
                                $('#categoria').val(datos[0].categoria);
                                $('#marca').val(datos[0].marca);
                                $('#modelo').val(datos[0].modelo);
                                $('#etiqueta').val(datos[0].etiqueta);
                                $('#pvp').val(datos[0].pvp);
                                
                                document.getElementById("referencia").disabled = true;
                                document.getElementById("marca").disabled = true;
                                
                                $("#formularioRepuesto").modal('show');
                            },
                            error: function()
                            {
                                alert("Hubo un error al recuperar los datos");
                            }  
                        });
                }
                
            function modificarRepuesto(registro)
                {
                    $.ajax(
                        {
                            type: "POST",
                            url: "datosApple.php?accion=modificar&referencia=" + registro.referencia,
                            data: registro,
                            
                            success: function(msg)
                            {
                                tabla1.ajax.reload();
                            },
                            error: function()
                            {
                                alert("Hubo un error al modificar el registro"); 
                            } 

                        }); 

                }

            $('#confirmarAgregar').click(function()
                {
                    let registro = recuperarDatosFormulario();
                    if(registro.referencia == '')
                    {
                        alert ("La referencia no puede estar vacio");
                        return;
                    }
                    if(registro.categoria == '')
                    {
                        alert ("La categoria no puede estar vacia");
                        return;
                    } 
                    if(registro.marca == '')
                    {
                        alert ("La marca no puede estar vacia");
                        return;
                    } 
                    if(registro.modelo == '')
                    {
                        alert ("El modelo no puede estar vacia");
                        return;
                    } 
                    if(registro.etiqueta == '')
                    {
                        alert ("La etiquetano puede estar vacia");
                        return;
                    } 
                    if(registro.pvp == '')
                    {
                        registro.pvp=0;
                    } 
                    
                    $("#formularioRepuesto").modal('hide');
                    agregarRegistro(registro);
                });

            $('#confirmarModificar').click(function()
                {
                    let registro = recuperarDatosFormulario();
                    if(registro.referencia == '')
                    {
                        alert ("La referencia no puede estar vacio");
                        return;
                    }
                    if(registro.categoria == '')
                    {
                        alert ("La categoria no puede estar vacia");
                        return;
                    } 
                    if(registro.marca == '')
                    {
                        alert ("La marca no puede estar vacia");
                        return;
                    } 
                    if(registro.modelo == '')
                    {
                        alert ("El modelo no puede estar vacia");
                        return;
                    } 
                    if(registro.etiqueta == '')
                    {
                        alert ("La etiquetano puede estar vacia");
                        return;
                    } 
                    if(registro.pvp == '')
                    {
                        registro.pvp=0;
                    } 

                    $("#formularioRepuesto").modal('hide');
                    modificarRepuesto(registro);   
                });  
            
            $('#repuestos tbody').on('click',"button.botonBorrar", function()
                    {
                        let registro = tabla1.row($(this).parents('tr')).data();
                        let mensaje = 'Seguro que desea eliminar a:\n\n' + registro.referencia;
                        if(confirm(mensaje))
                        {
                            borrarRegistro(registro.referencia);
                        } 
                    })

            $('#repuestos tbody').on('click',"button.botonModificar", function()
                    {
                        $("#confirmarAgregar").hide();
                        $("#confirmarModificar").show();
                        let registro = tabla1.row($(this).parents('tr')).data();
                    
                        recuperarRegistro(registro.referencia);
                        document.getElementById("cabecera").innerText = "Modificar referencia"
                        
                    })



            function formularioClave()
                {
                    limpiarFormularioClave();
                    
                    $("#formularioClave").modal('show');
                }
            
            function limpiarFormularioClave()
                {
                    $('#claveActual').val('');
                    $('#claveNueva').val ('');
                    $('#claveRepetida').val('');
                }

            $('.claveCambio').keyup (function(){
                validaClave();
            });        
            

            function validaClave() 
            {
                var claveNueva = $('#claveNueva').val();
                var claveRepetida = $('#claveRepetida').val();

                if (claveNueva != claveRepetida)
                {
                    $('.mensajeAlerta').html('<p style="color:red;"> Las contraseñas no son iguales.</p>');
                    $('.mensajeAlerta').slideDown();
                    return false;
                }

                $('.mensajeAlerta').html('');
                $('.mensajeAlerta').slideUp(); 
                
            }

            $('#confirmarCambiar').click (function() 
            {
                var claveActual = $('#claveActual').val();
                var claveNueva = $('#claveNueva').val();
                var claveRepetida = $('#claveRepetida').val();
                var accion = 'cambiarClave';

                if (claveNueva != claveRepetida)
                {
                    $('.mensajeAlerta').html('<p style="color:red;"> Las contraseñas no son iguales.</p>');
                    $('.mensajeAlerta').slideDown();
                    return false;
                }
                if (claveActual==''|| claveNueva==''|| claveRepetida=='')
                {
                    $('.mensajeAlerta').html('<p style="color:red;"> Las contraseñas no pueden estar vacias.</p>');
                    $('.mensajeAlerta').slideDown();
                    return false;
                }

                $.ajax(
                        {
                            type: "POST",
                            url: "datosClave.php",
                            async: true,
                            data:{accion:accion, claveActual:claveActual,claveNueva:claveNueva},
                            dataType:"json",
                            success: function(respuesta)
                            {
                                alert(respuesta.msg);
                            },
                            error: function(error)
                            {
                              alert("Error en el script");  
                            } 

                        });
                    $("#formularioClave").modal('hide');
            });    

        </script>

    </body>
</html>
