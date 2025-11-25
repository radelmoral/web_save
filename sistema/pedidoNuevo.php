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
                            <label for="origen" class="col-4 col-form-label">Origen:</label>
                            <div class="col-6">
                                <select class="form-select " id="origen">
                                   <!-- se rellena con funcion -->
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                               <input type="text" class="form-control" placeholder="Introduzca URL" id="url" hidden> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-primary" type="button" id="nuevaLinea">
                            <span class="bi bi-clipboard2-plus-fill"></span> Añadir linea
                        </button>
                        <button class="btn btn-primary" type="button" id="enviar">
                            <span class="bi bi-send-check"></span> Realizar pedido
                        </button>
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
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Formulario para agregar referencia -->
            <div class="modal fade" id="formularioNuevaLinea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog"> 
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
                                    <label for="referencia">Referencia:</label>
                                    <input type="text" id="referencia" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="etiqueta">Etiqueta:</label>
                                    <input type="text" id="etiqueta" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="unidades">Unidades:</label>
                                    <input type="number" min="1" max="4" id="unidades" class="form-control" placeholder="*">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-check">
                                    <input type="checkbox" id="enTienda" class="form-check-input">
                                    <label class="form-check-label" for="enTienda">En tienda:</label>
                                </div>
                            </div> 
                            <div class="form-row">
                                 <div class="form-check">
                                    <input type="checkbox" id="deposito" class="form-check-input" >
                                    <label class="form-check-label" for="deposito">Deposito 30%:</label>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <textarea maxlength="100" id="comentarios" class="form-control" placeholder="Informacion adicional" rows="3"></textarea>
                                    <!--label for="comentario" class="form-label">Etiqueta:</label-->
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

            let tabla2=$("#referencias").DataTable
            ({  orderCellsTop:true,
                fixedHeader: true,
                dom:"lrtip",
                rowId: 'idLinea',
               columns:
                    [
                    {data:}
                    {data: "referencia"},
                    {data: "etiqueta"},
                    {data: "unidades"},
                    {data: "enTienda",
                        render: function(data, type, row)
                        {
                            if (data==='on')
                            {
                                return '<input type="checkbox" class="editor-active" onclick="return false;" checked>';
                            }
                            else
                            {
                                return '<input type="checkbox" class="editor-active" onclick="return false;" >';
                            }
                        },
                        className: "dt-body-center text-center"
                    },
                    {data: "deposito",
                         render: function(data, type, row)
                        {
                            if (data==='on')
                            {
                                return '<input type="checkbox" class="editor-active" onclick="return false;" checked>';
                            }
                            else
                            {
                                return '<input type="checkbox" class="editor-active" onclick="return false;">';
                            }
                        },
                         className: "dt-body-center text-center"
                    },
                    {data: "comentarios", 
                     orderable: false,
                     render:function(data, type, row)
                        {
                            return data.length > 10 ? data.substr( 0, 20 ) +'…' :data;
                        }
                    },
                    {data: null,
                        defaultContent:
                            '<div class="action-buttons">' +
                                '<span class="editar"><i class="bi bi-pencil"></i></span> ' +
                                '<span class="borrar"><i class="bi bi-trash"></i></span> ' +
                            '</div>',
                        className: 'row-edit dt-center',
                        orderable: false
                    }],
                    
                columnDefs:
                    [{
                        targets:0,
                        width:"15%"
                    },
                    {   
                        targets:1,
                        width:"20%"
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
                    }],
                language:
                {
                    "url": "../js/spanish.json",
                }       
            });

        
        // Eventos que interactuan con el formulario de entrada

        $('#nuevaLinea').click (function()
            {
                $("#confirmarAgregar").show();
                $("#confirmarModificar").hide();
                limpiarFormulario();
                document.getElementById("cabecera").innerText = "Nueva linea";
                $("#formularioNuevaLinea").modal('show');
            });
        
        function limpiarFormulario()
            {
                $('#referencia').val('');
                $('#unidades').val('');
                $('#etiqueta').val ('');
                $('#enTienda').prop('checked', false);
                $('#deposito').prop('checked', false);
                $('#comentarios').val('');
            } 

        
        $('#confirmarAgregar').click(function()
            {
                let registro = recuperarNuevaLinea();
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
                
                $("#formularioNuevaLinea").modal('hide');
                tabla2.row.add(registro).draw(false);
            });

        $('#confirmarModificar').click(function()
            {
                let registro = recuperarNuevaLinea();
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
                
                $("#formularioNuevaLinea").modal('hide');
                tabla2.row(idRegistro).data(registro).draw();  
            });  

        $('#referencias tbody').on('click',"span.editar", function()
            {
                $("#confirmarAgregar").hide();
                $("#confirmarModificar").show();
                let idRegistro = tabla2.row(this).id();
                console.log("Hola");
                let registro = tabla2.row($(this).parents('tr')).data();
                $("#referencia").val(registro.referencia);
                $("#etiqueta").val(registro.etiqueta);
                $("#unidades").val(registro.unidades);
                $("#enTienda").val(registro.enTienda);
                $("#deposito").val(registro.deposito);
                $("#comentarios").val(registro.comentarios);
                document.getElementById("cabecera").innerText = "Modificar referencia";
                $("#formularioNuevaLinea").modal('show');
            });
       
        $('#referencias tbody').on('click',"span.borrar", function()
            {
                tabla2
                .row($(this).parents('tr'))
                .remove()
                .draw();
            });

        
        function recuperarNuevaLinea()
            {
    
                let registro =
                {
                referencia: $('#referencia').val(),
                etiqueta: $('#etiqueta').val (),
                unidades: $('#unidades').val(),
                enTienda: $('#enTienda:checked').val(),
                deposito: $('#deposito:checked').val(),
                comentarios:$('#comentarios').val()
                };
                return registro;
            }
        
        $ (function rellenaSelect()
        {
            $.ajax(
                {
                    type: "GET",
                    url: "datosPedidos.php?accion=listarTipoPedido",
                    data: '',
                    success: function(origen)
                           {
                                    $('#origen').append('<option value="0">Seleccione Tipo pedido</option>');
                                    $('#origen').append('<optgroup label="Externo" id="externo"><optgroup/>');
                                    var len = origen.length;
                                    for (var i=0;i<len; i++)
                                    {
                                         $('#externo').append('<option value="'+ origen[i].idTipo + '">' + origen[i].tipo + '</option>');
                                    }
                            },
                   error: function()
                  {
                        alert("Hubo un error al recuperar los datos Tipo de pedido");
                  }  
                });
            
            $.ajax(
            {
                type: "GET",
                url: "datosPedidos.php?accion=listarTiendas",
                data: '',
                success: function(tiendas)
                        {
                                $('#tienda').append('<option value="0">Seleccione tienda</option>');
                                $('#origen').append('<optgroup label="Tienda" id="interno"><optgroup/>');
                                var len = tiendas.length;
                                for (var i=0;i<len; i++)
                                {
                                    $('#tienda').append('<option value="'+ tiendas[i].idTienda + '">' + tiendas[i].tienda + '</option>');
                                     $('#interno').append('<option value="'+ tiendas[i].idTienda + '">' + tiendas[i].tienda + '</option>');
                                }
                        },
                error: function()
                {
                    alert("Hubo un error al recuperar los datos de tiendas");
                }  
            });
        }) 

        //Habilitar input URL si se selecciona

        $('#origen').change(function(e) 
        {
            if ($(this).val() === "2")
                {
                $('#url').show();
                } 
            else {
                $('#url').hide();
                }
        })

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
