<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Proveedor</h2>
        <div class="CrearOcultar">
            <p class="btn btn-primary" id="AbrirModal">
                Nuevo
            </p>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="TablaMarca">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Proveedor</th>
                            <th>Telefono</th>
                            <th>Municipio</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="CrearMostrar">
            <form>
                <input type="hidden" name="Prov_Id" id="Prov_Id">
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">Proveedor</label>
                        <input name="Proveedor" id="Proveedor" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Telefono</label>
                        <input name="Telefono" id="Telefono" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Municipio</label>
                        <input name="Municipio" id="Municipio" class="form-control letras" />
                        <span class="text-danger"></span>
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
    </div>
</div>

<script>
$(document).ready(function () {
    $('#TablaMarca').DataTable({
        "ajax": {
            "url": "Controllers/ProveedorController.php",
            "type": "POST",
            "data": function(d) {
                d.action = 'listarProveedores';
            },
            "dataSrc": function(json){
                return json.data;
            }
        },
        "columns": [
            { "data": "Prov_Id" },
            { "data": "Prov_Proveedor" },
            { "data": "Prov_Telefono" },
            { "data": "Muni_Municipio" },
            { 
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <a class='btn btn-primary btn-sm abrir-editar' data-id='${data.Prov_Id}'>
                            <i class='fas fa-edit'></i> Editar
                        </a> 
                        <a class='btn btn-secondary btn-sm ver-detalles' data-id='${data.Prov_Id}'>
                            <i class='fas fa-eye'></i> Detalles
                        </a> 
                        <button class='btn btn-danger btn-sm eliminar' data-id='${data.Prov_Id}'>
                            <i class='fas fa-eraser'></i> Eliminar
                        </button>
                    `;
                },
                "defaultContent": ""
            }
        ]
    });

    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
});

$(document).on('click', '.abrir-editar', function () {
    var provId = $(this).data('id');
    console.log('ID del proveedor:', provId); // Verifica el ID del proveedor en la consola
    $.ajax({
        url: 'Controllers/ProveedorController.php',
        type: 'GET',
        data: {
            action: 'buscar',
            Prov_Id: provId
        },
        success: function (response) {
            console.log('Response from server:', response); // Verifica la respuesta del servidor en la consola
            try {
                var proveedor = JSON.parse(response);
                $('#Prov_Id').val(provId);
                $('#Proveedor').val(proveedor.Prov_Proveedor);
                $('#Telefono').val(proveedor.Prov_Telefono);
                $('#Municipio').val(proveedor.Muni_Codigo);
                $('.CrearOcultar').hide();
                $('.CrearMostrar').show();
            } catch (e) {
                console.error('Error parsing JSON:', e);
                alert('Error parsing JSON response.');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Error:', errorThrown);
            alert('Error fetching or parsing the response.');
        }
    });
});

$('#guardarBtn').click(function() {
    var action = $('#Prov_Id').val() ? 'actualizar' : 'insertar';
    var provId = $('#Prov_Id').val();
    console.log('Prov_Id enviado:', provId); // Verifica si se envía el ID del proveedor al servidor
    var proveedor = $('#Proveedor').val();
    var telefono = $('#Telefono').val();
    var municipio = $('#Municipio').val();
    var usuarioId = 1;
    var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');

    $.ajax({
        url: 'Controllers/ProveedorController.php',
        type: 'POST',
        data: {
            action: action,
            Prov_Id: provId,
            Prov_Proveedor: proveedor,
            Prov_Telefono: telefono,
            Muni_Codigo: municipio,
            Prov_UsuarioCreacion: usuarioId,
            Prov_FechaCreacion: fecha,
            Prov_UsuarioModificacion: usuarioId,
            Prov_FechaModificacion: fecha
        },
        success: function(response) {
            console.log('Response from server:', response);
            if (response == 1) {
                alert('Proveedor guardado correctamente.');
                $('#TablaMarca').DataTable().ajax.reload();
                $('.CrearMostrar').hide();
                $('.CrearOcultar').show();
            } else {
                alert('Error al guardar el proveedor.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', errorThrown);
            alert('Error al guardar el proveedor.');
        }
    });
});

$('#CerrarModal').click(function() {
    $('.CrearMostrar').hide();
    $('.CrearOcultar').show();
});

$(document).on('click', '.ver-detalles', function() {
    var provId = $(this).data('id');
    // Lógica para mostrar los detalles del proveedor con el provId
});

$(document).on('click', '.eliminar', function() {
    var provId = $(this).data('id');
    // Lógica para eliminar el proveedor con el provId
});
</script>
