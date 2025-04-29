<?php
    session_start();
    
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>SAVE gestión artículos</title>

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/datatables.min.css">

        <script type="text/javascript" src="../js/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/popper.min.js"></script>
        <script type="text/javascript" src="../js/datatables.min.js"></script>


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
                           <?php
                            if ($_SESSION['rol']==1)
                            {
                               echo '<li class="nav-item"><a class="nav-link" href="#">Añadir usuario</a></li>
                               <li class="nav-item"><a class="nav-link" href="#">Listar usuarios</a></li>
                               <li class="dropdown-divider"></li>
                               <li class="nav-item"><a class="nav-link" href="javascript:formularioReferencia();">Añadir referencia</a></li>
                               <li class="nav-item"><a class="nav-link" href="#">Listar referencias</a></li>
                               <li class="dropdown-divider"></li>';  

                            } 
                            ?> 
                            <li class="nav-item"><a class="nav-link" href="#">Salir</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Cambiar contraseña</a></li>
                        </ul>
                    </div >
                    <div class="mx-auto">
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" placeholder="Referencia" aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Buscar</button>
                        </form>
                    </div>
                </div>
            </nav> 

            <h1>Listado Artículos</h1>
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
                            <th>Modificar</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                </table>
                <button class="btn btn-sm btn-primary" id="btnAgregar">Agregar referencia</button>
            </div>

            
            <div class="modal fade" id="formularioRepuesto" tabindex="-1" role="dialog"> <!-- Formulario para agregar articulos -->d
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">X</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Referencia:</label>
                                    <input type="text" id="referencia" class="form-control" placeholder="">
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
                                    <input type="number" id="pvp" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="confirmarAgregar" class="btn btn-success">Agregar</button>
                            <button type="button" id="confirmarModificar" class="btn btn-success">Modificar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>

                </div>
                
            </div> <!--  Fin formulario agregar articulo -->
            
        </div>

        <script>

let tabla1=$("#repuestos").DataTable
            (
                {
                    "ajax":
                    {
                        url: "datos.php?accion=listar",
                        dataSrc: "" 
                    },
                    "columns":
                    [
                        {
                            "data": "referencia"
                        },
                        {
                            "data": "categoria" 
                        },
                        {
                            "data": "marca" 
                        },
                        {
                            "data": "modelo" 
                        },
                        {
                            "data": "etiqueta" 
                        },
                        {
                            "data": "pvp" 
                        },
                        {
                            "data": null,
                            "orderable": false
                        },
                        {
                            "data": null,
                            "orderable": false
                        }
                    ],
                    "columnDefs":
                    [   {
                            targets: 6,
                            "defaultContent": "<button class='btn bt-sm btn-primary botonmodificar'>Modificar</button>",
                            data: null
                        },
                        {
                            targets: 7,
                            "defaultContent": "<button class='btn bt-sm btn-primary botonborrar'>Borrar</button>",
                            data: null
                        }
                    ],
                    "language":
                        {
                            "url": "../js/spanish.json",
                        },        
                }
            );
            // Eventos de botones
            $('#btnAgregar').click(function()
                {
                    $("#confirmarAgregar").show();
                    $("#confirmarModificar").hide();
                    $("#formularioRepuesto").modal('show');
                });
                $('#formularioReferencia').click(function()
                {
                    $("#confirmarAgregar").show();
                    $("#confirmarModificar").hide();
                    limpiarFormulario();
                    $("#formularioRepuesto").modal('show');
                });


                // Eventos que interactuan con el formulario de entrada

       function limpiarFormulario()
           {
                $('#referencia').val('');
                $('#categoria').val ('');
                $('#marca').val('');
                $('#modelo').val('');
                $('#etiqueta').val('');
                $('#pvp').val('');
                
           } 

        function formularioReferencia()
            {
                $("#confirmarAgregar").show();
                $("#confirmarModificar").hide();
                limpiarFormulario();
                $("#formularioRepuesto").modal('show');
            }
           
            
        </script>

    </body>
</html>
