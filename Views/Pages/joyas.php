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
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Stock</th>
                                <th>Precio Mayorista</th>
                                <th>Imagen</th>
                                <th>Material</th>
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
                            <label class="control-label">Precio Venta</label>
                            <input name="Joya_Codigo" class="form-control" id="Joya_Codigo" required/>
                            <div class="error-message" id="Joya_Codigo_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Nombre</label>
                            <input name="Joya_Nombre" class="form-control" id="Joya_Nombre" required/>
                            <div class="error-message" id="Joya_Nombre_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Precio Compra</label>
                            <input name="Joya_PrecioCompra" class="form-control" id="Joya_PrecioCompra" required/>
                            <div class="error-message" id="Joya_PrecioCompra_error"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Precio Venta</label>
                            <input name="Joya_PrecioVenta" class="form-control" id="Joya_PrecioVenta" required/>
                            <div class="error-message" id="Joya_PrecioVenta_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Precio Mayorista</label>
                            <input name="Joya_PrecioMayor" class="form-control" id="Joya_PrecioMayor" required/>
                            <div class="error-message" id="Joya_PrecioMayor_error"></div>
                        </div>
                    </div>
                    <div class="form-row">
                    
                        <div class="col-md-6">
                            <label class="control-label">Imagen</label>
                            <input type="file" name="Joya_Imagen" class="form-control" id="Joya_Imagen" required/>
                            <div class="error-message" id="Joya_Imagen_error"></div>
                        </div>
                    </div>
                    <div class="form-row">
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
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Categoría</label>
                            <select name="Cate_Id" class="form-control" id="Cate_Id" required></select>
                            <div class="error-message" id="Cate_Id_error"></div>
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
                    <p id="detallesContenido"></p>
                    <div class="form-row d-flex justify-content-end">
                        <div class="col-md-3">
                            <a id="CerrarDetalles" class="btn btn-secondary" style="color:white">Volver</a>
                        </div>
                    </div>
                </div>
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script>
$(document).ready(function () {
    var table = $('#TablaJoya').DataTable({
    "ajax": {
        "url": "Controllers/JoyasController.php",
        "type": "POST",
        "data": function(d) {
            d.action = 'listarJoyas';
        },
        "dataSrc": function(json){
            return json.data;
        }
    },
    "columns": [
        { "data": "Joya_Id" },
        { "data": "Joya_Codigo" },
        { "data": "Joya_Nombre" },
        { "data": "Joya_PrecioCompra" },
        { "data": "Joya_PrecioVenta" },
        { "data": "Joya_Stock" },
        { "data": "Joya_PrecioMayor" },
        {
            "data": "Joya_Imagen",
            "render": function (data, type, row) {
                var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/joyas/' + encodeURIComponent(data);
                return '<img src="' + imageUrl + '" alt="Imagen de Joya" width="50">';
            }
        },
        { "data": "Mate_Material" },
        { "data": "Prov_Proveedor" },
        { "data": "Cate_Categoria" },
        { 
            "data": null, 
            "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i> Editar</a> <a class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i> Detalles</a> <button class='btn btn-danger btn-sm abrir-eliminar'><i class='fas fa-eraser'></i> Eliminar</button>"
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

    async function cargarDropdowns(selectedData = {}) {
        try {
            const proveedores = await $.ajax({ url: 'Controllers/JoyasController.php', type: 'POST', data: { action: 'listarProveedores' } });
            const materiales = await $.ajax({ url: 'Controllers/JoyasController.php', type: 'POST', data: { action: 'listarMateriales' } });
            const categorias = await $.ajax({ url: 'Controllers/JoyasController.php', type: 'POST', data: { action: 'listarCategorias' } });

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
    cargarDropdowns();
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

    $('#guardarBtn').click(function() {
    $('.error-message').text('');
    var isValid = true;

    // Validar campos
    if ($('#Joya_Codigo').val().trim() === '') {
        $('#Joya_Codigo_error').text('Este campo es requerido');
        isValid = false;
    }
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
        joyaData.append('Joya_Codigo', $('#Joya_Codigo').val());
        joyaData.append('Joya_Nombre', $('#Joya_Nombre').val());
        joyaData.append('Joya_PrecioCompra', $('#Joya_PrecioCompra').val());
        joyaData.append('Joya_PrecioVenta', $('#Joya_PrecioVenta').val());
        joyaData.append('Joya_PrecioMayor', $('#Joya_PrecioMayor').val());
        joyaData.append('Joya_Imagen', $('#Joya_Imagen')[0].files[0]);
        joyaData.append('Joya_Stock',1);
        joyaData.append('Prov_Id', $('#Prov_Id').val());
        joyaData.append('Mate_Id', $('#Mate_Id').val());
        joyaData.append('Cate_Id', $('#Cate_Id').val());
        joyaData.append('Joya_UsuarioCreacion', 1);
        joyaData.append('Joya_FechaCreacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
        joyaData.append('Joya_UsuarioModificacion', 1);
        joyaData.append('Joya_FechaModificacion', new Date().toISOString().slice(0, 19).replace('T', ' '));

        $.ajax({
            url: 'Controllers/JoyasController.php',
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


    $('#TablaJoya tbody').on('click', '.abrir-eliminar', function () {
        var data = table.row($(this).parents('tr')).data();
        var joyaId = data.Joya_Id;
        $('#eliminarModal').modal('show');
        $('#confirmarEliminarBtn').data('joya-id', joyaId);
    });

    $('#confirmarEliminarBtn').click(function() {
        var joyaId = $(this).data('joya-id');
        $.ajax({
            url: 'Controllers/JoyasController.php',
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
                    iziToast.error({
                        title: 'Error',
                        message: 'Error al eliminar joya.',
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
    });

    $('#TablaJoya tbody').on('click', '.abrir-detalles', function () {
        var data = table.row($(this).parents('tr')).data();
        var detalles = `
           <p><strong>Codigo:</strong> ${data.Joya_Codigo}</p>
            <p><strong>Nombre:</strong> ${data.Joya_Nombre}</p>
            <p><strong>Precio Compra:</strong> ${data.Joya_PrecioCompra}</p>
            <p><strong>Precio Venta:</strong> ${data.Joya_PrecioVenta}</p>
            <p><strong>Stock:</strong> ${data.Joya_Stock}</p>
            <p><strong>Precio Mayorista:</strong> ${data.Joya_PrecioMayor}</p>
            <p><strong>Imagen:</strong> <img src="${data.Joya_Imagen}" alt="Imagen de Joya" width="50"></p>
            <p><strong>Material:</strong> ${data.Mate_Material}</p>
            <p><strong>Proveedor:</strong> ${data.Prov_Proveedor}</p>
            <p><strong>Categoría:</strong> ${data.Cate_Categoria}</p>
        `;
        $('#detallesContenido').html(detalles);
        $('.CrearOcultar').hide();
        $('.CrearDetalles').show();
    });

    $('#TablaJoya tbody').on('click', '.abrir-editar', function () {
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
     

        // Mostrar el formulario de edición
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
    });

});

</script>
</body>
</html>
