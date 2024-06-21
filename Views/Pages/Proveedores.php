<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Proveedor</title>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-body">
        <h2 class="text-center" style="font-size: 90px !important">Proveedores</h2>
                <div class="CrearOcultar" style="position:relative; top:-30px">
            <p class="btn btn-primary" id="AbrirModal">Nuevo</p>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="TablaMarca">
                    <thead>
                        <tr>
                        <th>#</th>
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
        <div class="d-flex justify-content-end">
                        <a href="#" id="Regresar" style="color: black;" class="btn btn-link">Regresar</a>
                    </div>
            <form id="proveedorForm">
                <input type="hidden" name="Prov_Id" id="Prov_Id">
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">Proveedor</label>
                        <input name="Proveedor" id="Proveedor" class="form-control letras" required />
                        <span class="text-danger" id="ProveedorError"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Telefono</label>
                        <input name="Telefono" id="Telefono" class="form-control" required />
                        <span class="text-danger" id="TelefonoError"></span>
                    </div>
                    <div class="col-md-6">
    <label class="control-label">Municipio</label>
    <select name="Municipio" id="Municipio" class="form-control" required>
        <option value="">Selecciona un municipio</option>
        <!-- Opciones de municipios se cargarán aquí dinámicamente -->
    </select>
    <span class="text-danger" id="MunicipioError"></span>
</div>


                </div>
                <div class="card-body">
                    <div class="form-row d-flex justify-content-end">
                        <div class="col-auto">
                            <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn" />
                        </div>
                        <div class="col-auto">
                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Cancelar</a>
                        </div>
                    </div>
                </div>


            </form>
        </div>

            <!-- Collapse Detalles -->
            <div class="CrearDetalles collapse" id="detallesCollapse">
            <div class="d-flex justify-content-end">
                        <a href="#" id="CerrarDetalles" style="color: black;" class="btn btn-link">Regresar</a>
                    </div>
                <div class="card card-body">
                    <h5>Detalles del Proveedor</h5>
                    <p id="detallesContenido"></p>
                    <div class="form-row d-flex justify-content-end">
                        <div class="col-md-3">
                            <a id="CerrarDetalles" class="btn btn-secondary" style="color:white">Cancelar</a>
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
                ¿Estás seguro de que deseas eliminar estE pROVEEDOR?
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">SI</button>
            <button type="button" class="btn btn-secondary" style="color: white;" data-dismiss="modal">NO</button>
            </div>
        </div>
    </div>
</div>





<script>
$(document).ready(function () {
    $('#TablaMarca').DataTable({
        "ajax": {
            "url": "Services/ProveedorService.php",
            "type": "POST",
            "data": function(d) {
                d.action = 'listarProveedores';
            },
            "dataSrc": function(json){
                return json.data;
            }
        },
        "columns": [
            { "data": null },
            { "data": "Prov_Proveedor" },
            { "data": "Prov_Telefono" },
            { "data": "Muni_Municipio" },
            {
    "data": null,
    "render": function (data, type, row) {
        return `
            <div class='text-center'>
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cogs"></i> Acciones
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item abrir-editar" data-id='${data.Prov_Id}' href="#">
                            <i class='fas fa-edit'></i> Editar
                        </a> 
                        <a class="dropdown-item ver-detalles" data-id='${data.Prov_Id}' href="#">
                            <i class='fas fa-eye'></i> Detalles
                        </a>
                        <button class="dropdown-item eliminar" data-id='${data.Prov_Id}' data-toggle='modal' data-target='#eliminarModal'>
                            <i class='fas fa-trash-alt'></i> Eliminar
                        </button>
                    </div>
                </div>
            </div>
        `;
    },
    "defaultContent": ""
}

        ],
        "createdRow": function(row, data, dataIndex) {
      
        $('td:eq(0)', row).html(dataIndex + 1);
    }
    });

    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();

    $('#Proveedor').on('keypress', function (e) {
        if (e.which >= 48 && e.which <= 57) {
            e.preventDefault();
        }
    });

    $('#Telefono').on('input', function () {
        var telefono = $(this).val();
        if (telefono.length > 8) {
            $(this).val(telefono.slice(0, 8));
        }
    });

    $('#Municipio').change(function() {
        var municipioSeleccionado = $(this).val();
        console.log('Municipio seleccionado:', municipioSeleccionado); // Agrega este console.log para verificar el valor seleccionado
        municipio = municipioSeleccionado;
    });

    $('#guardarBtn').click(function() {
        var proveedor = $('#Proveedor').val().trim();
        var telefono = $('#Telefono').val().trim();
    
        var isValid = true;

        if (proveedor === '') {
            isValid = false;
            $('#ProveedorError').text('Este campo es requerido.');
        } else {
            $('#ProveedorError').text('');
        }

        if (telefono === '') {
            isValid = false;
            $('#TelefonoError').text('Este campo es requerido.');
        } else if (!/^\d{8}$/.test(telefono)) {
            isValid = false;
            $('#TelefonoError').text('El teléfono debe tener 8 dígitos.');
        } else {
            $('#TelefonoError').text('');
        }

        if (municipio === '') {
            isValid = false;
            $('#MunicipioError').text('Este campo es requerido.');
        } else {
            $('#MunicipioError').text('');
        }

        if (!isValid) {
            return;
        }

        var action = $('#Prov_Id').val() ? 'actualizar' : 'insertar';
        var provId = $('#Prov_Id').val();
        var usuarioId = 1;
        var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');
        console.log('Datos a enviar:', {
    action: action,
    Prov_Id: provId,
    Prov_Proveedor: proveedor,
    Prov_Telefono: telefono,
    Muni_Codigo: municipio,
    Prov_UsuarioCreacion: usuarioId,
    Prov_FechaCreacion: fecha,
    Prov_UsuarioModificacion: usuarioId,
    Prov_FechaModificacion: fecha
});
        $.ajax({
            url: 'Services/ProveedorService.php',
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
                    iziToast.success({
                    title: 'Éxito',
                    message: 'Proveedor guardado correctamente.',
                });
                
                    $('#TablaMarca').DataTable().ajax.reload();
                    limpiarFormulario();
                    $('.CrearMostrar').hide();
                    $('.CrearOcultar').show();
                } else {
                    iziToast.error({
                    title: 'Error',
                    message: 'Error al guadarar al proveedor.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX'
                });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
                alert('Error al guardar el proveedor.');
            }
        });
    });

    $('#CerrarModal').click(function() {
        limpiarFormulario();
        $('.CrearMostrar').hide();
        $('.CrearOcultar').show();
    });

    function limpiarFormulario() {
        $('#proveedorForm')[0].reset();
        $('#ProveedorError').text('');
        $('#TelefonoError').text('');
        $('#MunicipioError').text('');
    }

    $('#AbrirModal').click(function() {
        limpiarFormulario();
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
        cargarMunicipios();
    });

    
    $('#CerrarDetalles').click(function() {
    $('#detallesCollapse').collapse('hide'); // Ocultar el Collapse de detalles al hacer clic en Cancelar
    $('.CrearOcultar').show();
});

$(document).on('click', '.abrir-editar', function () {
    var provId = $(this).data('id');
    
    console.log('ID del proveedor:', provId);
    $.ajax({
        url: 'Services/ProveedorService.php',
        type: 'GET',
        data: {
            action: 'buscar',
            Prov_Id: provId
        },
        success: function (response) {
            console.log('Response from server:', response);
            try {
                var proveedor = JSON.parse(response);
                $('#Prov_Id').val(provId);
                $('#Proveedor').val(proveedor.Prov_Proveedor);
                $('#Telefono').val(proveedor.Prov_Telefono);
                
                // Seleccionar automáticamente el municipio en el select #Municipio
                var selectMunicipio = $('#Municipio');
                selectMunicipio.val(proveedor.Muni_Codigo);

                // Mostrar el nombre del municipio solo para verificar
                console.log('Nombre del municipio seleccionado:', proveedor.Muni_Municipio);

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






    $(document).on('click', '.ver-detalles', function() {
    var provId = $(this).data('id');
    
    // Realizar una solicitud AJAX para obtener los detalles del proveedor con el provId
    $.ajax({
        url: 'Services/ProveedorService.php',
        type: 'GET',
        data: {
            action: 'buscar',
            Prov_Id: provId
        },
        success: function (response) {
            console.log('Detalles del proveedor:', response);
            try {
                var detalles = JSON.parse(response);
                mostrarDetallesProveedor(detalles);
                $('.CrearOcultar').hide();
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
function mostrarDetallesProveedor(detalles) {
    var datosProveedor;
    if (typeof detalles === 'object') {
        datosProveedor = detalles; // Si detalles ya es un objeto, úsalo directamente
    } else {
        try {
            datosProveedor = JSON.parse(detalles); // Si detalles es una cadena JSON, conviértela en un objeto
        } catch (error) {
            console.error('Error al parsear JSON:', error);
            $('#detallesContenido').html('<p>Error al cargar los detalles del proveedor.</p>');
            $('#detallesCollapse').collapse('show'); // Mostrar el Collapse de detalles
            return; // Salir de la función si hay un error al analizar JSON
        }
    }

    // Generar HTML para los detalles generales del proveedor
    var detallesGeneralesHTML = `
        <p><strong>Proveedor:</strong> ${datosProveedor.Prov_Proveedor}</p>
        <p><strong>Teléfono:</strong> ${datosProveedor.Prov_Telefono}</p>
        <p><strong>Municipio:</strong> ${datosProveedor.Muni_Codigo} - ${datosProveedor.Muni_Municipio}</p>
    `;

    // Generar HTML para los detalles de auditoría del proveedor
    var detallesAuditoriaHTML = `
        <p><strong>Usuario de Creación:</strong> ${datosProveedor.Prov_UsuarioCreacion}</p>
        <p><strong>Fecha de Creación:</strong> ${datosProveedor.Prov_FechaCreacion}</p>
        <p><strong>Usuario de Modificación:</strong> ${datosProveedor.Prov_UsuarioModificacion}</p>
        <p><strong>Fecha de Modificación:</strong> ${datosProveedor.Prov_FechaModificacion}</p>
    `;

    // Combinar ambas secciones en el HTML final
    var detallesHTML = `
        <div class="detalles-generales">
            <h4>Detalles Generales</h4>
            ${detallesGeneralesHTML}
        </div>
        <div class="detalles-auditoria">
            <h4>Detalles de Auditoría</h4>
            ${detallesAuditoriaHTML}
        </div>
    `;

    $('#detallesContenido').html(detallesHTML);
    $('#detallesCollapse').collapse('show'); // Mostrar el Collapse de detalles
}


var provIdToDelete; // Variable global para almacenar el ID del proveedor a eliminar

$(document).on('click', '.eliminar', function() {
    provIdToDelete = $(this).data('id');
    console.log('ID del proveedor:', provIdToDelete);
    $('#eliminarModal').modal('show');
});

$('#confirmarEliminarBtn').click(function() {
    if (provIdToDelete) {
        $.ajax({
            url: 'Services/ProveedorService.php',
            type: 'POST',
            data: {
                action: 'eliminar',
                Prov_Id: provIdToDelete
            },
            success: function(response) {
                console.log('Response from server:', response);
                if (response == 1) {
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Proveedor eliminado correctamente.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#TablaMarca').DataTable().ajax.reload(function() {
                        $('#eliminarModal').modal('hide'); // Cierra el modal después de cargar la tabla
                    });
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error al eliminar el proveedor.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown);
                iziToast.error({
                    title: 'Error',
                    message: 'Error al eliminar el proveedor.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX'
                });
            }
        });
    }
});

$('#Regresar').click(function() {
            limpiarFormulario();
       
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
            $('.CrearDetalles').hide();
        });

function cargarMunicipios() {
        $.ajax({
            url: 'Services/ProveedorService.php',
            type: 'POST',
            data: { action: 'listarMunicipios' }, // Acción para listar los municipios
            success: function(response) {
                var municipios = JSON.parse(response).data;
                var municipioDropdown = $('#Municipio');
                municipioDropdown.empty();
                municipios.forEach(function(municipio) {
                    municipioDropdown.append('<option value="' + municipio.Muni_Codigo + '">' + municipio.Muni_Municipio + '</option>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar municipios:', error);
            }
        });
    }

    // Llamar a la función para cargar los municipios al cargar la página
    cargarMunicipios();



    
});
</script>
<style>
.modal-header.bg-danger {
    background-color: #dc3545;
    color: #fff;
}
/* Estilo personalizado para el modal de confirmación de eliminación */
.modal-header {
    border-bottom: none;
}

.modal-header h5 {
    font-weight: bold;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: none;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
    color: #fff;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
    color: #fff;
}

</style>
