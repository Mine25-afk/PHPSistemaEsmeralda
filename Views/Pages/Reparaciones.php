<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Reparaciones</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="font-size:34px !important">Reparaciones</h2>
            <div class="CrearOcultar">
            <p class="btn btn-primary" id="AbrirModal">
                Nuevo
            </p>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="Tablaone">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo</th>
                            <th>Tipo Reparacion</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="CrearMostrar">
            <form id="ReparacionForm">
                <input type="hidden" name="Repa_Id" id="Repa_Id">
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">Codigo</label>
                        <input name="Repa_Codigo" id="Repa_Codigo" class="form-control letras" required />
                        <span class="text-danger" id="ProveedorError"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Reparacion</label>
                        <input name="Repa_Tipo_Reparacion" id="Repa_Tipo_Reparacion" class="form-control" required />
                        <span class="text-danger" id="TelefonoError"></span>
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
                    <h5>Detalles de la Reparaciones</h5>
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



</body>
</html>


<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este proveedor?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Sí, Eliminar</button>
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
    // Inicializar DataTable
    $('#Tablaone').DataTable({
        "ajax": {
            "url": "Controllers/ReparacionesController.php",
            "type": "POST",
            "data": function(d) {
                d.action = 'listarReparaciones';
            },
            "dataSrc": function(json){
                return json.data;
            }
        },
        "columns": [
            { "data": "Repa_Id" },
            { "data": "Repa_Codigo" },
            { "data": "Repa_Tipo_Reparacion" },
            { 
                "data": null,
                "render": function (data, type, row) {
                    return `
                        <a class='btn btn-primary btn-sm abrir-editar' data-id='${data.Repa_Id}'>
                            <i class='fas fa-edit'></i> Editar
                        </a> 
                        <a class='btn btn-secondary btn-sm ver-detalles' data-id='${data.Repa_Id}'>
                            <i class='fas fa-eye'></i> Detalles
                        </a>
                        <button class='btn btn-danger btn-sm eliminar' data-id='${data.Repa_Id}' data-toggle='modal' data-target='#eliminarModal'>
                            <i class='fas fa-eraser'></i> Eliminar
                        </button>
                    `;
                },
                "defaultContent": ""
            }
        ]
    });

    // Mostrar y ocultar secciones del formulario
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();



// Limitar el campo Reparacion a solo letras
$('#Repa_Tipo_Reparacion').on('input', function () {
    var reparacion = $(this).val();
    var letras = /^[A-Za-z\s]+$/; // Expresión regular para validar letras y espacios

    if (!reparacion.match(letras)) {
        $(this).val(reparacion.replace(/[^A-Za-z\s]/g, '')); // Eliminar caracteres no permitidos
    }
});

// Limitar el campo Codigo a 12 caracteres
$('#Repa_Codigo').on('input', function () {
    var codigo = $(this).val();

    if (codigo.length > 12) {
        $(this).val(codigo.slice(0, 12)); // Limitar a 12 caracteres
    }
});


    // Guardar o actualizar reparación
    $('#guardarBtn').click(function() {
        var Codigo = $('#Repa_Codigo').val().trim();
        var TipoReparacion = $('#Repa_Tipo_Reparacion').val().trim();
        var RepaId = $('#Repa_Id').val(); // Obtener el ID del campo oculto
        var isValid = validarFormulario(Codigo, TipoReparacion);

        if (!isValid) {
            return;
        }

        var action = RepaId ? 'actualizar' : 'insertar';
        var usuarioId = 1;
        var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');

        // Añadir console.log para depurar
        console.log('Action:', action);
        console.log('Repa_Id:', RepaId);

        $.ajax({
            url: 'Controllers/ReparacionesController.php',
            type: 'POST',
            data: {
                action: action,
                Repa_Id: RepaId,
                Repa_Codigo: Codigo,
                Repa_Tipo_Reparacion: TipoReparacion,
                Repa_UsuarioCreacion: usuarioId,
                Repa_FechaCreacion: fecha,
                Repa_UsuarioModifica: usuarioId,
                Repa_FechaModifica: fecha
            },
            success: function(response) {
                console.log('Response:', response);
                if (response == 1) {
                    iziToast.success({
                    title: 'Éxito',
                    message: 'Reparacion guardado correctamente.',
                });
                    $('#Tablaone').DataTable().ajax.reload();
                    limpiarFormulario();
                    $('.CrearMostrar').hide();
                    $('.CrearOcultar').show();
                } else {
                    iziToast.error({
                    title: 'Error',
                    message: 'Error al guardar la Reparacion.',
                });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error al guardar el proveedor.');
            }
        });
    });

    // Limpiar y cerrar formulario
    $('#CerrarModal').click(function() {
        limpiarFormulario();
        $('.CrearMostrar').hide();
        $('.CrearOcultar').show();
    });

    // Abrir modal de creación/edición
    $('#AbrirModal').click(function() {
        limpiarFormulario();
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
    });

    // Cerrar detalles y mostrar sección de creación
    $('#CerrarDetalles').click(function() {
        $('#detallesCollapse').collapse('hide');
        $('.CrearOcultar').show();
    });

    // Editar reparación
    $(document).on('click', '.abrir-editar', function () {
        var RepaId = $(this).data('id');
        console.log('Edit Repa_Id:', RepaId); // Añadir console.log para depurar
        $.ajax({
            url: 'Controllers/ReparacionesController.php',
            type: 'GET',
            data: {
                action: 'buscar',
                Repa_Id: RepaId
            },
            success: function (response) {
                try {
                    var Reparaciones = JSON.parse(response);
                    console.log('Fetched Reparaciones:', Reparaciones); // Añadir console.log para depurar
                    $('#Repa_Id').val(RepaId); // Establecer el ID en el campo oculto
                    $('#Repa_Codigo').val(Reparaciones.Repa_Codigo);
                    $('#Repa_Tipo_Reparacion').val(Reparaciones.Repa_Tipo_Reparacion);
                    $('.CrearOcultar').hide();
                    $('.CrearMostrar').show();
                } catch (e) {
                    alert('Error parsing JSON response.');
                }
            },
            error: function () {
                alert('Error fetching or parsing the response.');
            }
        });
    });

    // Ver detalles de reparación
    $(document).on('click', '.ver-detalles', function() {
        var RepaId = $(this).data('id');
        $.ajax({
            url: 'Controllers/ReparacionesController.php',
            type: 'GET',
            data: {
                action: 'buscar',
                Repa_Id: RepaId
            },
            success: function (response) {
                try {
                    var detalles = JSON.parse(response);
                    mostrarDetalles(detalles);
                    $('.CrearOcultar').hide();
                } catch (e) {
                    alert('Error parsing JSON response.');
                }
            },
            error: function () {
                alert('Error fetching or parsing the response.');
            }
        });
    });
    function mostrarDetalles(detalles) {
    var datosGeneralesHTML = '';
    var datosAuditoriaHTML = '';

    if (typeof detalles === 'object') {
        // Datos Generales
        datosGeneralesHTML += `
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Repa_Id:</strong> ${detalles.Repa_Id}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Codigo:</strong> ${detalles.Repa_Codigo}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Repa_Tipo_Reparacion:</strong> ${detalles.Repa_Tipo_Reparacion}</p>
                </div>
            </div>
        `;

        // Datos de Auditoría
        datosAuditoriaHTML += `
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Repa_UsuarioCreacion:</strong> ${detalles.Repa_UsuarioCreacion}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Repa_FechaCreacion:</strong> ${detalles.Repa_FechaCreacion}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Repa_UsuarioModifica:</strong> ${detalles.Repa_UsuarioModifica}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Repa_FechaModifica:</strong> ${detalles.Repa_FechaModifica}</p>
                </div>
            </div>
        `;
    } else {
        try {
            var datos = JSON.parse(detalles);

            // Datos Generales
            datosGeneralesHTML += `
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Repa_Id:</strong> ${datos.Repa_Id}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Repa_Codigo:</strong> ${datos.Repa_Codigo}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Repa_Tipo_Reparacion:</strong> ${datos.Repa_Tipo_Reparacion}</p>
                    </div>
                </div>
            `;

            // Datos de Auditoría
            datosAuditoriaHTML += `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Repa_UsuarioCreacion:</strong> ${datos.Repa_UsuarioCreacion}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Repa_FechaCreacion:</strong> ${datos.Repa_FechaCreacion}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Repa_UsuarioModifica:</strong> ${datos.Repa_UsuarioModifica}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Repa_FechaModifica:</strong> ${datos.Repa_FechaModifica}</p>
                    </div>
                </div>
            `;
        } catch (error) {
            $('#detallesContenido').html('<p>Error al cargar los detalles de la reparación.</p>');
            $('#detallesCollapse').collapse('show');
            return;
        }
    }

    var detallesHTML = `
        <div class="datos-generales">
            <h4>Datos Generales</h4>
            ${datosGeneralesHTML}
        </div>
        <div class="datos-auditoria">
            <h4>Datos de Auditoría</h4>
            ${datosAuditoriaHTML}
        </div>
    `;

    $('#detallesContenido').html(detallesHTML);
    $('#detallesCollapse').collapse('show');
}


    var proveedorIdParaEliminar; // Variable global para almacenar el ID del proveedor a eliminar

// Eliminar reparación
$(document).on('click', '.eliminar', function () {
    proveedorIdParaEliminar = $(this).data('id');
    $('#confirmarEliminarModal').modal('show');
});

$('#confirmarEliminarBtn').click(function () {
    eliminarProveedor();
});

// Función para eliminar el proveedor
function eliminarProveedor() {
    $.ajax({
        url: 'Controllers/ReparacionesController.php',
        type: 'POST',
        data: {
            action: 'eliminar',
            Repa_Id: proveedorIdParaEliminar
        },
        success: function (response) {
            if (response == 1) {
                $('#Tablaone').DataTable().ajax.reload();
                
                iziToast.success({
    title: 'Éxito',
    message: 'Proveedor eliminado correctamente.',
});

            } else {
           
                iziToast.error({
    title: 'Error',
    message: 'Error al eliminar el proveedor..',
});
            }
        },
        error: function () {
       
            iziToast.error({
    title: 'Error',
    message: 'Error al eliminar el proveedor.',
});
        }
    });
}


    // Validación del formulario
    function validarFormulario(Codigo, TipoReparacion) {
        if (Codigo === '' || TipoReparacion === '') {
            iziToast.error({
                    title: 'Error',
                    message: 'Por favor, complete todos los campos requeridos.',
                });
            return false;
        }
        return true;
    }

    // Limpiar formulario
    function limpiarFormulario() {
        $('#ReparacionForm')[0].reset();
        $('#Repa_Id').val('');
    }
});

</script>

<style>
.modal-header.bg-danger {
    background-color: #dc3545;
    color: #fff;
}
</style>
