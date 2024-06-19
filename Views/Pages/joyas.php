<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Joyas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.875em;
        }

        .acciones-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .acciones-container .btn {
            margin: 2px;
        }


        @media (max-width: 768px) {
            .acciones-container {
                flex-wrap: wrap;
                justify-content: center;
            }

            .acciones-container .btn {
                flex: 1 0 auto;
                margin: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center" style="font-size:34px !important">Joyas</h2>
                <div class="CrearOcultar">
                    <button class="btn btn-primary" id="AbrirModal">Nuevo</button>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="TablaJoya">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Descripción</th>
                      
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Precio Mayorista</th>
                                    <th>Imagen</th>
                                  
                                    <th>Proveedor</th>
                                    <th>Categoría</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <div class="CrearMostrar">
                    <form id="joyaForm" enctype="multipart/form-data">
                        <input type="hidden" name="Joya_Id" id="Joya_Id">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="control-label">Nombre</label>
                                <input name="Joya_Nombre" class="form-control" id="Joya_Nombre" required />
                                <div class="error-message" id="Joya_Nombre_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Precio Compra</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">LPS</span>
                                    </div>
                                    <input name="Joya_PrecioCompra" type="number" min="0" class="form-control" id="Joya_PrecioCompra" required />
                                </div>
                                <div class="error-message" id="Joya_PrecioCompra_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Precio Venta</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">LPS</span>
                                    </div>
                                    <input name="Joya_PrecioVenta" type="number" min="0" class="form-control" id="Joya_PrecioVenta" required />
                                </div>
                                <div class="error-message" id="Joya_PrecioVenta_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Precio Mayorista</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">LPS</span>
                                    </div>
                                    <input name="Joya_PrecioMayor" type="number" min="0" class="form-control" id="Joya_PrecioMayor" required />
                                </div>
                                <div class="error-message" id="Joya_PrecioMayor_error"></div>
                            </div>

                            <div class="col-md-6">
                                <label class="control-label">Proveedor</label>
                                <select name="Prov_Id" class="form-control" id="Prov_Id" required></select>
                                <div class="error-message" id="Prov_Id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Material</label>
                                <select name="Mate_Id" class="form-control" id="Mate_Id" required></select>

                                <div class="error-message" id="Mate_Id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Categoría</label>
                                <select name="Cate_Id" class="form-control" id="Cate_Id" required></select>
                                <div class="error-message" id="Cate_Id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Imagen</label>
                                <input type="file" name="Joya_Imagen" class="form-control" id="Joya_Imagen" required />
                                <div class="error-message" id="Joya_Imagen_error"></div>

                                <label class="control-label">Imagen Actual</label>
                                <div id="imagenActualContainer">
                                    <img id="imagenActual" src="#" alt="Imagen Actual" style="max-width: 100%;" />
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="form-row d-flex justify-content-end">
                                <div class="col-md-3">
                                    <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn" />
                                </div>
                                <div class="col-md-3">
                                    <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <!-- Collapse Detalles -->
                <div class="CrearDetalles collapse" id="detallesCollapse">
                    <div class="card card-body">
                        <h5>Detalles de la Joya</h5>
                        <div id="Detalles">
                            <div class="row" style="padding: 10px;">
                                <div class="col" style="font-weight:700">
                                    Código
                                </div>
                                <div class="col" style="font-weight:700">
                                    Nombre
                                </div>
                                <div class="col" style="font-weight:700">
                                    Precio Compra
                                </div>
                            </div>
                            <div class="row" style="padding: 10px;">
                                <div class="col">
                                    <label for="" id="detallesCodigo"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesNombre"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesPrecioCompra"></label>
                                </div>
                            </div>

                            <div class="row" style="padding: 10px;">
                                <div class="col" style="font-weight:700">
                                    Imagen
                                </div>
                                <div class="col" style="font-weight:700">
                                    Material
                                </div>
                                <div class="col" style="font-weight:700">
                                    Categoria
                                </div>
                            </div>
                            <div class="row" style="padding: 10px;">
                                <div class="col">
                                    <label for="" id="detallesImagen"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesMaterial"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesCategoria"></label>
                                </div>
                            </div>

                            <div class="row" style="padding: 10px;">
                                <div class="col" style="font-weight:700">
                                    Precio Venta
                                </div>
                                <div class="col" style="font-weight:700">
                                    Precio Mayor
                                </div>
                                <div class="col" style="font-weight:700">
                                    Proveedor
                                </div>
                            </div>
                            <div class="row" style="padding: 10px;">
                                <div class="col">
                                    <label for="" id="detallesPrecioVenta"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesPrecioMayor"></label>
                                </div>
                                <div class="col">
                                    <label for="" id="detallesProveedor"></label>
                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-body">
                                    <h5>Auditoria</h5>
                                    <hr>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Acciones</th>
                                                <th>Usuario</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Insertar</td>
                                                <td>
                                                    <label for="" id="detallesUsuarioCreacion"></label>
                                                </td>
                                                <td>
                                                    <label for="" id="detallesFechaCreacion"></label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Modificar</td>
                                                <td>
                                                    <label for="" id="detallesUsuarioModificacion"></label>
                                                </td>
                                                <td>
                                                    <label for="" id="detallesFechaModificacion"></label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-row d-flex justify-content-end">
                            <div class="col-md-3">
                                <a id="CerrarDetalles" class="btn btn-secondary" style="color:white">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Modal Eliminar -->
                <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar esta joya?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Código de Barras -->
                <div class="modal fade" id="codigoBarrasModal" tabindex="-1" aria-labelledby="codigoBarrasModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content d-flex justify-content-center align-items-center">
                            <div class="modal-header">
                                <h5 class="modal-title" id="codigoBarrasModalLabel">Código de Barras</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group text-center">
                                    <label for="cantidadCodigos">Cantidad de Códigos a Imprimir:</label>
                                    <input type="number" class="form-control form-control-sm" id="cantidadCodigos" min="1" value="1">
                                </div>
                                <div class="barcode-container text-center" id="barcodeContainer">
                               
                                </div>
                                <div class="joya-nombre mt-3 text-center">
                               
                                    <h5 id="nombreJoya"></h5>

                                </div>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-primary" id="generarCodigos">Generar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-success" id="imprimirCodigos">Imprimir</button>
                            </div>
                        </div>
                    </div>
                </div>



                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
                <script>
                    $(document).ready(function() {
                        var table = $('#TablaJoya').DataTable({
                            "ajax": {
                                "url": "Services/JoyasServices.php",
                                "type": "POST",
                                "data": function(d) {
                                    d.action = 'listarJoyas';
                                },
                                "dataSrc": function(json) {
                                    return json.data;
                                }
                            },
                            "columns": [{
                                    "data": "Joya_Id"
                                },
                                {
                                    "data": "Joya_Codigo"
                                },
                                {
                                    "data": "Joya_Nombre"
                                },
                            
                                {
                                    "data": "Joya_PrecioVenta"
                                },
                                {
                                    "data": "Joya_Stock"
                                },
                                {
                                    "data": "Joya_PrecioMayor"
                                },
                                {
                                    "data": "Joya_Imagen",
                                    "render": function(data, type, row) {
                                        var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/joyas/' + encodeURIComponent(data);
                                        return '<img src="' + imageUrl + '" alt="Imagen de Joya" width="50">';
                                    }
                                },
                             
                                {
                                    "data": "Prov_Proveedor"
                                },
                                {
                                    "data": "Cate_Categoria"
                                },
                                {
                                    "data": null,
                                    "defaultContent": "<div class='acciones-container'><a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i> Editar</a> <a class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i> Detalles</a> <button class='btn btn-danger btn-sm abrir-eliminar'><i class='fas fa-eraser'></i> Eliminar</button></div> <button class='btn btn-info btn-sm abrir-generar-codigo'><i class='fas fa-barcode'></i> Generar Código de Barras</button>"
                                }


                            ]
                        });

                        $('.CrearOcultar').show();
                        $('.CrearMostrar').hide();
                        $('.CrearDetalles').hide();

                        function limpiarFormulario() {
                            $('#joyaForm').trigger('reset');
                            $('.error-message').text('');
                            $('#Joya_Id').val('');
                        }

                        function cargarImagenActual(imagen) {
                            var imagenActual = $('#imagenActual');
                            if (imagen) {
                                var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/joyas/' + encodeURIComponent(imagen);
                                imagenActual
                                    .attr('src', imageUrl)
                                    .attr('style', 'max-width: 100%; max-height: 200px;')
                                    .show();
                            } else {
                                imagenActual
                                    .attr('src', '#')
                                    .hide();
                            }
                        }

                        async function cargarDropdowns(selectedData = {}) {
                            try {
                                const proveedores = await $.ajax({
                                    url: 'Services/JoyasServices.php',
                                    type: 'POST',
                                    data: {
                                        action: 'listarProveedores'
                                    }
                                });
                                const materiales = await $.ajax({
                                    url: 'Services/JoyasServices.php',
                                    type: 'POST',
                                    data: {
                                        action: 'listarMateriales'
                                    }
                                });
                                const categorias = await $.ajax({
                                    url: 'Services/JoyasServices.php',
                                    type: 'POST',
                                    data: {
                                        action: 'listarCategorias'
                                    }
                                });

                                const proveedorDropdown = $('#Prov_Id');
                                proveedorDropdown.empty();
                                JSON.parse(proveedores).data.forEach(proveedor => {
                                    proveedorDropdown.append('<option value="' + proveedor.Prov_Id + '">' + proveedor.Prov_Proveedor + '</option>');
                                });
                                if (selectedData.Prov_Id) {
                                    $('#Prov_Id').val(selectedData.Prov_Id);
                                }

                                const materialDropdown = $('#Mate_Id');
                                materialDropdown.empty();
                                JSON.parse(materiales).data.forEach(material => {
                                    materialDropdown.append('<option value="' + material.Mate_Id + '">' + material.Mate_Material + '</option>');
                                });
                                if (selectedData.Mate_Id) {
                                    $('#Mate_Id').val(selectedData.Mate_Id);
                                }

                                const categoriaDropdown = $('#Cate_Id');
                                categoriaDropdown.empty();
                                JSON.parse(categorias).data.forEach(categoria => {
                                    categoriaDropdown.append('<option value="' + categoria.Cate_Id + '">' + categoria.Cate_Categoria + '</option>');
                                });
                                if (selectedData.Cate_Id) {
                                    $('#Cate_Id').val(selectedData.Cate_Id);
                                }
                            } catch (error) {
                                console.error('Error cargando dropdowns:', error);
                            }
                        }

                        $('#AbrirModal').click(function() {
                            console.log('Botón Nuevo clickeado');
                            limpiarFormulario();
                            $('.CrearOcultar').hide();
                            $('.CrearMostrar').show();
                            $('#Joya_Codigo').val('01');
                            cargarDropdowns();


                            cargarImagenActual(null);
                        });


                        $('#CerrarModal').click(function() {
                            limpiarFormulario();
                            $('.CrearOcultar').show();
                            $('.CrearMostrar').hide();
                        });

                        $('#CerrarDetalles').click(function() {
                            $('.CrearOcultar').show();
                            $('.CrearDetalles').hide();
                        });

                        $('#Joya_Imagen').change(function() {
                            var input = this;
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    $('#imagenActual')
                                        .attr('src', e.target.result)
                                        .attr('style', 'max-width: 100%; max-height: 200px;')
                                        .show();
                                };
                                reader.readAsDataURL(input.files[0]);
                            }
                        });

                        $('#guardarBtn').click(function() {
                            $('.error-message').text('');
                            var isValid = true;


                            // Captura el valor del material seleccionado
                            var materialSeleccionado = $('#Mate_Id option:selected').text();
                            console.log('Material seleccionado:', materialSeleccionado);


                            if (materialSeleccionado === undefined) {
                                $('#Mate_Id_error').text('Este campo es requerido');
                                isValid = false;
                            }

                            //primeras dos letras del material 
                            var codigoMaterial = materialSeleccionado.substring(0, 2).toUpperCase();
                            console.log('Código del material:', codigoMaterial);

                            //codigo aleatorio
                            var codigoAleatorio = Math.floor(1000 + Math.random() * 9000);
                            console.log('Código aleatorio:', codigoAleatorio);


                            var joyaCodigo = codigoMaterial + codigoAleatorio;
                            console.log('Joya Código generado:', joyaCodigo);


                            $('#Joya_Codigo').val(joyaCodigo);

                            if ($('#Joya_Nombre').val().trim() === '') {
                                $('#Joya_Nombre_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Joya_PrecioCompra').val().trim() === '') {
                                $('#Joya_PrecioCompra_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Joya_PrecioVenta').val().trim() === '') {
                                $('#Joya_PrecioVenta_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Joya_PrecioMayor').val().trim() === '') {
                                $('#Joya_PrecioMayor_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Joya_Imagen').val().trim() === '') {
                                $('#Joya_Imagen_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Prov_Id').val() === null) {
                                $('#Prov_Id_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Mate_Id').val() === null) {
                                $('#Mate_Id_error').text('Este campo es requerido');
                                isValid = false;
                            }
                            if ($('#Cate_Id').val() === null) {
                                $('#Cate_Id_error').text('Este campo es requerido');
                                isValid = false;
                            }

                            if (isValid) {
                                var joyaData = new FormData();
                                joyaData.append('action', $('#Joya_Id').val() ? 'actualizar' : 'insertar');
                                joyaData.append('Joya_Id', $('#Joya_Id').val());
                                joyaData.append('Joya_Codigo', joyaCodigo);
                                joyaData.append('Joya_Nombre', $('#Joya_Nombre').val());
                                joyaData.append('Joya_PrecioCompra', $('#Joya_PrecioCompra').val());
                                joyaData.append('Joya_PrecioVenta', $('#Joya_PrecioVenta').val());
                                joyaData.append('Joya_PrecioMayor', $('#Joya_PrecioMayor').val());
                                joyaData.append('Joya_Imagen', $('#Joya_Imagen')[0].files[0]);
                                joyaData.append('Joya_Stock', 1);
                                joyaData.append('Prov_Id', $('#Prov_Id').val());
                                joyaData.append('Mate_Id', $('#Mate_Id').val());
                                joyaData.append('Cate_Id', $('#Cate_Id').val());
                                joyaData.append('Joya_UsuarioCreacion', 1);
                                joyaData.append('Joya_FechaCreacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
                                joyaData.append('Joya_UsuarioModificacion', 1);
                                joyaData.append('Joya_FechaModificacion', new Date().toISOString().slice(0, 19).replace('T', ' '));

                                $.ajax({
                                    url: 'Services/JoyasServices.php',
                                    type: 'POST',
                                    data: joyaData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        response = JSON.parse(response);
                                        if (response.result == 1) {
                                            iziToast.success({
                                                title: 'Éxito',
                                                message: 'Subido con éxito',
                                                position: 'topRight',
                                                transitionIn: 'flipInX',
                                                transitionOut: 'flipOutX'
                                            });
                                            table.ajax.reload();
                                            limpiarFormulario();
                                            $('.CrearOcultar').show();
                                            $('.CrearMostrar').hide();
                                        } else {
                                            iziToast.error({
                                                title: 'Error',
                                                message: 'Error al insertar/actualizar joya. ' + (response.error ? response.error : ''),
                                                position: 'topRight',
                                                transitionIn: 'flipInX',
                                                transitionOut: 'flipOutX'
                                            });
                                        }
                                    },
                                    error: function() {
                                        iziToast.error({
                                            title: 'Error',
                                            message: 'Error en la comunicación con el servidor.',
                                            position: 'topRight',
                                            transitionIn: 'flipInX',
                                            transitionOut: 'flipOutX'
                                        });
                                    }
                                });
                            }
                        });

                        $('#TablaJoya tbody').on('click', '.abrir-generar-codigo', function() {
                            var data = table.row($(this).parents('tr')).data();
                            var codigo = data.Joya_Codigo;
                            var nombre = data.Joya_Nombre; // Obtener el nombre de la joya

                            // Verificar si el código es válido y no está vacío
                            if (!codigo || codigo.length < 1) {
                                alert("El código es demasiado corto para generar un código de barras válido.");
                                return;
                            }

                            // Mostrar el modal
                            $('#codigoBarrasModal').modal('show');

                            // Guardar el código y el nombre en el modal
                            $('#codigoBarrasModal').data('codigo', codigo);
                            $('#codigoBarrasModal').data('nombre', nombre);

                            // Actualizar el nombre en el modal
                            $('#nombreJoya').text(nombre);

                            // Generar los códigos de barras inicialmente
                            generarCodigosBarras(codigo, nombre);
                        });


                   
                        function generarCodigosBarras(codigo, nombre) {
                            var cantidad = parseInt($('#cantidadCodigos').val());

                      
                            $('#barcodeContainer').empty();

                       
                            for (var i = 0; i < cantidad; i++) {
                                var svg = $('<svg class="barcode-item"></svg>');
                                JsBarcode(svg[0], codigo, {
                                    format: "CODE128",
                                    displayValue: true,
                                    fontSize: 20,
                                    text: codigo
                                });
                                $('#barcodeContainer').append(svg);

                                
                                console.log('Generando código de barras para ' + nombre);
                            }
                        }

               
                        $('#generarCodigos').click(function() {
                            var codigo = $('#codigoBarrasModal').data('codigo');
                            var nombre = $('#codigoBarrasModal').data('nombre');
                            generarCodigosBarras(codigo, nombre);
                        });

                   
                        $('#imprimirCodigos').click(function() {
                            var printContents = document.getElementById('barcodeContainer').innerHTML;
                            var originalContents = document.body.innerHTML;

                            document.body.innerHTML = printContents;
                            window.print();
                            document.body.innerHTML = originalContents;

                            location.reload(); 
                        });

                      
                        $('#cantidadCodigos').change(function() {
                            var codigo = $('#codigoBarrasModal').data('codigo');
                            var nombre = $('#codigoBarrasModal').data('nombre');
                            generarCodigosBarras(codigo, nombre);
                        });


                        $('#TablaJoya tbody').on('click', '.abrir-eliminar', function() {
                            var data = table.row($(this).parents('tr')).data();
                            var joyaId = data.Joya_Id;
                            $('#eliminarModal').modal('show');
                            $('#confirmarEliminarBtn').data('joya-id', joyaId);
                        });

                        $('#confirmarEliminarBtn').click(function() {
                            var joyaId = $(this).data('joya-id');
                            $.ajax({
                                url: 'Services/JoyasServices.php',
                                type: 'POST',
                                data: {
                                    action: 'eliminar',
                                    Joya_Id: joyaId
                                },
                                success: function(response) {
                                    if (response.result == 1) {
                                        iziToast.success({
                                            title: 'Éxito',
                                            message: 'Eliminado con éxito',
                                            position: 'topRight',
                                            transitionIn: 'flipInX',
                                            transitionOut: 'flipOutX'
                                        });
                                        table.ajax.reload();
                                        $('#eliminarModal').modal('hide');
                                    } else {
                                        iziToast.success({
                                            title: 'Éxito',
                                            message: 'Eliminado con éxito',
                                            position: 'topRight',
                                            transitionIn: 'flipInX',
                                            transitionOut: 'flipOutX'
                                        });
                                        table.ajax.reload();
                                        $('#eliminarModal').modal('hide');
                                    }
                                },
                                error: function() {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Error en la comunicación con el servidor.',
                                        position: 'topRight',
                                        transitionIn: 'flipInX',
                                        transitionOut: 'flipOutX'
                                    });
                                }
                            });
                        });

                        $('#TablaJoya tbody').on('click', '.abrir-detalles', function() {
                            var data = table.row($(this).parents('tr')).data();
                            $('#detallesCodigo').text(data.Joya_Codigo);
                            $('#detallesNombre').text(data.Joya_Nombre);
                            $('#detallesPrecioCompra').text(data.Joya_PrecioCompra);
                            $('#detallesPrecioVenta').text(data.Joya_PrecioVenta);
                            $('#detallesStock').text(data.Joya_Stock);
                            $('#detallesPrecioMayor').text(data.Joya_PrecioMayor);
                            var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/joyas/' + encodeURIComponent(data.Joya_Imagen);
                            $('#detallesImagen').html('<img src="' + imageUrl + '" alt="Imagen de Joya" width="50">');
                            $('#detallesMaterial').text(data.Mate_Material);
                            $('#detallesProveedor').text(data.Prov_Proveedor);
                            $('#detallesCategoria').text(data.Cate_Categoria);
                            $('#detallesUsuarioCreacion').text(data.UsuarioCreacion);
                            $('#detallesFechaCreacion').text(data.FechaCreacion);
                            $('#detallesUsuarioModificacion').text(data.UsuarioModificacion);
                            $('#detallesFechaModificacion').text(data.FechaModificacion);

                            $('.CrearOcultar').hide();
                            $('.CrearDetalles').show();
                        });


                        $('#TablaJoya tbody').on('click', '.abrir-editar', function() {
                            var data = table.row($(this).parents('tr')).data();
                            limpiarFormulario();

                            // Cargar los dropdowns con los valores seleccionados
                            cargarDropdowns(data);

                            // Llenar el formulario con los valores existentes
                            $('#Joya_Id').val(data.Joya_Id);
                            $('#Joya_Codigo').val(data.Joya_Codigo);
                            $('#Joya_Nombre').val(data.Joya_Nombre);
                            $('#Joya_PrecioCompra').val(data.Joya_PrecioCompra);
                            $('#Joya_PrecioVenta').val(data.Joya_PrecioVenta);
                            $('#Joya_PrecioMayor').val(data.Joya_PrecioMayor);
                            $('#Prov_Id').val(data.Prov_Id);
                            $('#Mate_Id').val(data.Mate_Id);
                            $('#Cate_Id').val(data.Cate_Id);
                            // $('#Joya_Imagen').val(data.Joya_Imagen);

                            // Cargar imagen actual
                            cargarImagenActual(data.Joya_Imagen);

                            // Mostrar el formulario de edición
                            $('.CrearOcultar').hide();
                            $('.CrearMostrar').show();
                        });
                        cargarImagenActual($('#Joya_Imagen').val());
                    });
                </script>
</body>

</html>