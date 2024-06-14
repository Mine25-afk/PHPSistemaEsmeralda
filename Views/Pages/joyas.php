<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Joyas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="font-size:34px !important">Joyas</h2>
            <div class="CrearOcultar">
                <p class="btn btn-primary" id="AbrirModal">Nuevo</p>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="TablaJoya">
                        <thead>
                            <tr>
                                <th>Id</th>
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
                    </table>
                </div>
            </div>

            <div class="CrearMostrar">
                <form id="joyaForm">
                    <input type="hidden" name="Joya_Id" id="Joya_Id">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Nombre</label>
                            <input name="Joya_Nombre" class="form-control" id="Joya_Nombre" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Precio Compra</label>
                            <input name="Joya_PrecioCompra" class="form-control" id="Joya_PrecioCompra" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Precio Venta</label>
                            <input name="Joya_PrecioVenta" class="form-control" id="Joya_PrecioVenta" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Precio Mayorista</label>
                            <input name="Joya_PrecioMayor" class="form-control" id="Joya_PrecioMayor" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Stock</label>
                            <input name="Joya_Stock" class="form-control" id="Joya_Stock" required/>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Imagen</label>
                            <input name="Joya_Imagen" class="form-control" id="Joya_Imagen" required/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Proveedor</label>
                            <select name="Prov_Id" class="form-control" id="Prov_Id" required></select>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Material</label>
                            <select name="Mate_Id" class="form-control" id="Mate_Id" required></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Categoría</label>
                            <select name="Cate_Id" class="form-control" id="Cate_Id" required></select>
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
                console.log(json);
                return json.data;
            }
        },
        "columns": [
            { "data": "Joya_Id" },
            { "data": "Joya_Nombre" },
            { "data": "Joya_PrecioCompra" },
            { "data": "Joya_PrecioVenta" },
            { "data": "Joya_Stock" },
            { "data": "Joya_PrecioMayor" },
            { "data": "Joya_Imagen" },
            { "data": "Mate_Material" },
            { "data": "Prov_Proveedor" },
            { "data": "Cate_Categoria" },
            { 
                "data": null, 
                "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</a> <a class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i>Detalles</a> <button class='btn btn-danger btn-sm abrir-eliminar'><i class='fas fa-eraser'></i> Eliminar</button>"
            }
        ]
    });

    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    $('.CrearDetalles').hide();

    function limpiarFormulario() {
        $('#joyaForm').trigger('reset');
        $('#Joya_Id').val('');
    }

    $('#AbrirModal').click(function() {
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
        var joyaData = {
            action: $('#Joya_Id').val() ? 'actualizar' : 'insertar',
            Joya_Id: $('#Joya_Id').val(),
            Joya_Nombre: $('#Joya_Nombre').val(),
            Joya_PrecioCompra: $('#Joya_PrecioCompra').val(),
            Joya_PrecioVenta: $('#Joya_PrecioVenta').val(),
            Joya_PrecioMayor: $('#Joya_PrecioMayor').val(),
            Joya_Imagen: $('#Joya_Imagen').val(),
            Joya_Stock: $('#Joya_Stock').val(),
            Prov_Id: $('#Prov_Id').val(),
            Mate_Id: $('#Mate_Id').val(),
            Cate_Id: $('#Cate_Id').val(),
            Joya_UsuarioCreacion: 1,
            Joya_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
            Joya_UsuarioModificacion: 1,
            Joya_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
        };

        $.ajax({
            url: 'Controllers/JoyasController.php',
            type: 'POST',
            data: joyaData,
            success: function(response) {
                console.log(response);
                if (response == 1) {
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
                    alert('Error al insertar/actualizar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
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
                if (response == 1) {
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
                    alert('Error al eliminar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    });

    $('#TablaJoya tbody').on('click', '.abrir-detalles', function () {
        var data = table.row($(this).parents('tr')).data();
        var detalles = `
            <p><strong>Nombre:</strong> ${data.Joya_Nombre}</p>
            <p><strong>Precio Compra:</strong> ${data.Joya_PrecioCompra}</p>
            <p><strong>Precio Venta:</strong> ${data.Joya_PrecioVenta}</p>
            <p><strong>Stock:</strong> ${data.Joya_Stock}</p>
            <p><strong>Precio Mayorista:</strong> ${data.Joya_PrecioMayor}</p>
            <p><strong>Imagen:</strong> ${data.Joya_Imagen}</p>
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
        $('#Joya_Id').val(data.Joya_Id);
        $('#Joya_Nombre').val(data.Joya_Nombre);
        $('#Joya_PrecioCompra').val(data.Joya_PrecioCompra);
        $('#Joya_PrecioVenta').val(data.Joya_PrecioVenta);
        $('#Joya_PrecioMayor').val(data.Joya_PrecioMayor);
        $('#Joya_Imagen').val(data.Joya_Imagen);
        $('#Joya_Stock').val(data.Joya_Stock);
        $('#Prov_Id').val(data.Prov_Id);
        $('#Mate_Id').val(data.Mate_Id);
        $('#Cate_Id').val(data.Cate_Id);

        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
        cargarDropdowns();
    });

    function cargarDropdowns() {
        $.ajax({
            url: 'Controllers/JoyasController.php',
            type: 'POST',
            data: { action: 'listarProveedores' },
            success: function(response) {
                var proveedores = JSON.parse(response).data;
                var proveedorDropdown = $('#Prov_Id');
                proveedorDropdown.empty();
                proveedores.forEach(function(proveedor) {
                    proveedorDropdown.append('<option value="' + proveedor.Prov_Id + '">' + proveedor.Prov_Proveedor + '</option>');
                });
            }
        });

        $.ajax({
            url: 'Controllers/JoyasController.php',
            type: 'POST',
            data: { action: 'listarMateriales' },
            success: function(response) {
                var materiales = JSON.parse(response).data;
                var materialDropdown = $('#Mate_Id');
                materialDropdown.empty();
                materiales.forEach(function(material) {
                    materialDropdown.append('<option value="' + material.Mate_Id + '">' + material.Mate_Material + '</option>');
                });
            }
        });

        $.ajax({
            url: 'Controllers/JoyasController.php',
            type: 'POST',
            data: { action: 'listarCategorias' },
            success: function(response) {
                var categorias = JSON.parse(response).data;
                var categoriaDropdown = $('#Cate_Id');
                categoriaDropdown.empty();
                categorias.forEach(function(categoria) {
                    categoriaDropdown.append('<option value="' + categoria.Cate_Id + '">' + categoria.Cate_Categoria + '</option>');
                });
            }
        });
    }
});

</script>
</body>
</html>
