<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Clientes</title>
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
            <h2 class="text-center" style="font-size: 34px !important">Clientes</h2>
            <div class="CrearOcultar">
                <button class="btn btn-primary" id="AbrirModal">Nuevo</button>
                <hr>
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="TablaCliente">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Fecha Nacimiento</th>
                            <th>Sexo</th>
                            <th>Municipio</th>
                            <th>Estado Civil</th>
                            <th>Es Mayorista</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="CrearMostrar">
                <form id="clienteForm">
                    <input type="hidden" name="Clie_Id" id="Clie_Id">

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label" for="Clie_Nombre">Nombre</label>
                            <input name="Clie_Nombre" type="text" class="form-control" id="Clie_Nombre" required>
                            <div class="error-message" id="Clie_Nombre_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Apellido</label>
                            <input name="Clie_Apellido" type="text" class="form-control" id="Clie_Apellido" required>
                            <div class="error-message" id="Clie_Apellido_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">DNI</label>
                            <input name="Clie_DNI" type="text" class="form-control" id="Clie_DNI" required>
                            <div class="error-message" id="Clie_DNI_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Fecha Nacimiento</label>
                            <input name="Clie_FechaNac" type="date" class="form-control" id="Clie_FechaNac" required>
                            <div class="error-message" id="Clie_FechaNac_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Municipio</label>
                            <select name="Muni_Codigo" class="form-control" id="Muni_Codigo" required></select>
                            <div class="error-message" id="Muni_Codigo_error"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Estado Civil</label>
                            <select name="Esta_Id" class="form-control" id="Esta_Id" required></select>
                            <div class="error-message" id="Esta_Id_error"></div>
                        </div>
                        <div class="col-md-6">
                                  <label>Sexo</label>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-radio mr-3">
                                            <input class="custom-control-input" type="radio" id="F" name="Sexo" value="F" >
                                            
                                            <label for="F" class="custom-control-label">Femenino</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="M" name="Sexo" value="M" >
                                            <label for="M" class="custom-control-label">Masculino</label>
                                        </div>
                                    </div>
                            <div class="error-message" id="Clie_Sexo_error"></div>
                        </div>



                        <div class="col-md-6">
                            <label class="control-label">Es Mayorista</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Clie_esMayorista" id="esMayoristaSi" value="true" required>
                                    <label class="form-check-label" for="esMayoristaSi">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="Clie_esMayorista" id="esMayoristaNo" value="false" required>
                                    <label class="form-check-label" for="esMayoristaNo">No</label>
                                </div>
                            </div>
                            <div class="error-message" id="Clie_esMayorista_error"></div>
                        </div>




                    </div>
                    <div class="card-body">
                        <div class="form-row d-flex justify-content-end">
                            <div class="col-md-3">
                                <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn">
                            </div>
                            <div class="col-md-3">
                                <a id="CerrarModal" class="btn btn-secondary" style="color: white;">Volver</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Collapse Detalles -->
            <div class="CrearDetalles collapse" id="detallesCollapse">
    <div class="card card-body">
        <h5>Detalles de Clientes</h5>
        <div id="Detalles">
            <div class="row" style="padding: 10px;">
                <div class="col-md-4" style="font-weight: 700;">
                    Nombre
                </div>
                <div class="col-md-4" style="font-weight: 700;">
                    Apellidos
                </div>
                <div class="col-md-4" style="font-weight: 700;">
                    Fecha de Nacimiento
                </div>
            </div>
            <div class="row" style="padding: 10px;">
                <div class="col-md-4">
                    <label for="" id="detallesNombres"></label>
                </div>
                <div class="col-md-4">
                    <label for="" id="detallesApellido"></label>
                </div>
                <div class="col-md-4">
                    <label for="" id="detallesFechaNac"></label>
                </div>
            </div>

            <div class="row" style="padding: 10px;">
                <div class="col-md-4" style="font-weight: 700;">
                    DNI
                </div>
                <div class="col-md-4" style="font-weight: 700;">
                    Municipio
                </div>
                <div class="col-md-4" style="font-weight: 700;">
                    Estado Civil
                </div>
            </div>
            <div class="row" style="padding: 10px;">
                <div class="col-md-4">
                    <label for="" id="detallesDNI"></label>
                </div>
                <div class="col-md-4">
                    <label for="" id="detallesMunicipios"></label>
                </div>
                <div class="col-md-4">
                    <label for="" id="detallesEstadoCivil"></label>
                </div>
            </div>

            <div class="row" style="padding: 10px;">
                <div class="col-md-4" style="font-weight: 700;">
                    Sexo
                </div>
                <div class="col-md-4" style="font-weight: 700;">
                    Es Mayorista
                </div>
            </div>
            <div class="row" style="padding: 10px;">
                <div class="col-md-4">
                    <label for="" id="detallesSexo"></label>
                </div>
                <div class="col-md-4">
                    <label for="" id="detallesMayorista"></label>
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
        <div class="form-row d-flex justify-content-end mt-3">
            <div class="col-md-3">
                <a id="CerrarDetalles" class="btn btn-secondary" style="color: white;">Volver</a>
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
                ¿Estás seguro de que deseas eliminar este CLiente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ingresar código de autorización -->
<div class="modal fade" id="modalAutorizacion" tabindex="-1" aria-labelledby="modalAutorizacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAutorizacionLabel">Código de Autorización</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCodigoAutorizacion">
                    <div class="form-group">
                        <label for="codigoAutorizacion">Ingrese el código de autorización:</label>
                        <input type="text" class="form-control" id="codigoAutorizacion" required>
                    </div>
                    <div id="codigoAutorizacion_error" class="error-message"></div>
                    <button type="button" class="btn btn-primary" id="verificarCodigoBtn">Verificar</button>
                </form>
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
    var table = $('#TablaCliente').DataTable({
    "ajax": {
        "url": "Services/ClientesServices.php",
        "type": "POST",
        "data": function(d) {
            d.action = 'listarClientes';
        },
        "dataSrc": function(json){
            return json.data;
        }
    },
    "columns": [
        { "data": "Clie_Id" },
        { "data": "Clie_Nombre" },
        { "data": "Clie_Apellido" },
        { "data": "Clie_DNI" },
        { "data": "Clie_FechaNac" },
        { "data": "Clie_Sexo" },
        { "data": "Municipio" },
        { "data": "Estado_Civil" },
        { "data": "Clie_esMayorista" },
        {
            "data": null,
            "defaultContent": "<div class='acciones-container'><a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i> Editar</a> <a class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i> Detalles</a> <button class='btn btn-danger btn-sm abrir-eliminar'><i class='fas fa-eraser'></i> Eliminar</button></div>"
        }


    ]
});



    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    $('.CrearDetalles').hide();

    function limpiarFormulario() {
        $('#clienteForm').trigger('reset');
        $('.error-message').text('');
        $('#Clie_Id').val('');
    }



    async function cargarDropdowns(selectedData = {}) {
        try {
            const municipios = await $.ajax({ url: 'Services/ClientesServices.php', type: 'POST', data: { action: 'listarMunicipios' } });
            const estadosCiviles = await $.ajax({ url: 'Services/ClientesServices.php', type: 'POST', data: { action: 'listarEstadosCiviles' } });
          

            const municipiosDropdown = $('#Muni_Codigo');
            municipiosDropdown.empty();
            JSON.parse(municipios).data.forEach(municipios => {
                municipiosDropdown.append('<option value="' + municipios.Muni_Codigo + '">' + municipios.Muni_Municipio + '</option>');
            });
            if (selectedData.Muni_Codigo) {
                $('#Muni_Codigo').val(selectedData.Muni_Codigo);
            }

            const EstadoCivilDropdown = $('#Esta_Id');
            EstadoCivilDropdown.empty();
            JSON.parse(estadosCiviles).data.forEach(estadosCiviles => {
                EstadoCivilDropdown.append('<option value="' + estadosCiviles.Esta_Id + '">' + estadosCiviles.Esta_EstadoCivil + '</option>');
            });
            if (selectedData.Esta_Id) {
                $('#Esta_Id').val(selectedData.Esta_Id);
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
    console.log('Botón Guardar clickeado');
    $('.error-message').text('');
    var isValid = true;

    var nombre = $('#Clie_Nombre').val();
    console.log('Valor de Clie_Nombre:', nombre);
    if (!nombre || nombre.trim() === '') {
        $('#Clie_Nombre_error').text('Este campo es requerido');
        isValid = false;
    }

    var apellido = $('#Clie_Apellido').val();
    console.log('Valor de Clie_Apellido:', apellido);
    if (!apellido || apellido.trim() === '') {
        $('#Clie_Apellido_error').text('Este campo es requerido');
        isValid = false;
    }

    var fechaNac = $('#Clie_FechaNac').val();
    console.log('Valor de Clie_FechaNac:', fechaNac);
    if (!fechaNac || fechaNac.trim() === '') {
        $('#Clie_FechaNac_error').text('Este campo es requerido');
        isValid = false;
    }

    var sexo = $('input[name="Sexo"]:checked').val();
    if (!sexo) {
        $('#Clie_Sexo_error').text('Selecciona una opción');
        isValid = false;
    }

    console.log('Valor de Clie_Sexo:', sexo); 



    var esMayorista = $('input[name="Clie_esMayorista"]:checked').val() === "true";

// Verificar si es mayorista y el código no está verificado
if (esMayorista && !codigoVerificado) {
    // Mostrar mensaje de error y no permitir guardar
    iziToast.error({
        title: 'Error',
        message: 'Por favor, ingrese el código de autorización primero.',
        position: 'topRight',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX'
    });
    isValid = false;
}
  

      var municipio = $('#Muni_Codigo').val();
    if (!municipio) {
        $('#Muni_Codigo_error').text('Este campo es requerido');
        isValid = false;
    }

    var estado = $('#Esta_Id').val();
    if (!estado) {
        $('#Esta_Id_error').text('Este campo es requerido');
        isValid = false;
    }
  

    if (isValid) {
        var clienteData = new FormData();
        clienteData.append('action', $('#Clie_Id').val() ? 'actualizar' : 'insertar');
        clienteData.append('Clie_Id', $('#Clie_Id').val());
        clienteData.append('Clie_Nombre', $('#Clie_Nombre').val());
        clienteData.append('Clie_Apellido', $('#Clie_Apellido').val());
        clienteData.append('Clie_DNI', $('#Clie_DNI').val());
        clienteData.append('Clie_FechaNac', $('#Clie_FechaNac').val());
        clienteData.append('Clie_Sexo', sexo);

        clienteData.append('Muni_Codigo', $('#Muni_Codigo').val());
        clienteData.append('Esta_Id', $('#Esta_Id').val());
        clienteData.append('Clie_esMayorista', esMayorista);
        clienteData.append('Clie_UsuarioCreacion', 1);
        clienteData.append('Clie_FechaCreacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
        clienteData.append('Clie_UsuarioModificacion', 1);
        clienteData.append('Clie_FechaModificacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
        console.log('Datos a enviar:', clienteData);

        $.ajax({
            url: 'Services/ClientesServices.php',
            type: 'POST',
            data: clienteData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                try {
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
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Error al insertar/actualizar cliente. ' + (response.error ? response.error : ''),
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    }
                } catch (e) {
                    console.log('Error al analizar la respuesta del servidor:', e);
                    iziToast.error({
                        title: 'Error',
                        message: 'Respuesta inválida del servidor',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log('Error en la comunicación con el servidor:', error);
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


    $('#TablaCliente tbody').on('click', '.abrir-eliminar', function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(data);
        var Clie_Id = data.Clie_Id;
        sessionStorage.setItem('Clie_Id', Clie_Id);
        $('#eliminarModal').modal('show');
        });

        $('#confirmarEliminarBtn').click(function() {
        var Clie_Id = sessionStorage.getItem('Clie_Id');
        $.ajax({
            url: 'Services/ClientesServices.php',
            type: 'POST',
            data: {
                action: 'eliminar',
                Clie_Id: Clie_Id
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
                    $('#TablaCliente').DataTable().ajax.reload();
                    $('#eliminarModal').modal('hide');
                    sessionStorage.setItem('Clie_Id', "0");
                } else {
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Eliminado con éxito',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#TablaCliente').DataTable().ajax.reload();
                    $('#eliminarModal').modal('hide');
                    sessionStorage.setItem('Clie_Id', "0");
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    });  

    $('#TablaCliente tbody').on('click', '.abrir-detalles', function () {
    var data = table.row($(this).parents('tr')).data();
    $('#detallesNombres').text(data.Clie_Nombre);
    $('#detallesApellido').text(data.Clie_Apellido);
    $('#detallesFechaNac').text(data.Clie_FechaNac);
    $('#detallesDNI').text(data.Clie_DNI);
    $('#detallesMayorista').text(data.Clie_esMayorista);
    $('#detallesSexo').text(data.Clie_Sexo);
    $('#detallesMunicipios').text(data.Municipio);
    $('#detallesEstadoCivil').text(data.Estado_Civil);
    $('#detallesUsuarioCreacion').text(data.UsuarioCreacion);
    $('#detallesFechaCreacion').text(data.Clie_FechaCreacion);
    $('#detallesUsuarioModificacion').text(data.UsuarioModificacion);
    $('#detallesFechaModificacion').text(data.Clie_FechaModificacion);

    $('.CrearOcultar').hide();
    $('.CrearDetalles').show();
});


$('input[name="Clie_esMayorista"]').change(function() {
        if ($(this).val() === 'true') {
            $('#modalAutorizacion').modal('show'); 
            enviarCorreo(); 
        }
    });

    // Función para enviar el correo electrónico
    function enviarCorreo() {
        $.ajax({
            type: 'POST',
            url: 'Services/EnviarCorreo.php',
            success: function(response) {
                console.log('Correo enviado:', response);
            },
            error: function(xhr, status, error) {
                console.error('Error al enviar correo:', error);
            }
        });
    }

  // Variable para almacenar si el código ha sido verificado
var codigoVerificado = false;

// Función para verificar el código de autorización
$('#verificarCodigoBtn').click(function() {
    var codigo = $('#codigoAutorizacion').val();

    $.ajax({
        type: 'POST',
        url: 'Services/verificar_codigo.php',
        data: { codigo: codigo },
        dataType: 'json',
        success: function(response) {
            if (response.valid) {
                iziToast.success({
                    title: 'Éxito',
                    message: 'Código Verificado',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX'
                });
                $('#modalAutorizacion').modal('hide');
                codigoVerificado = true; // Marcar como verificado
                puedeGuardar(); // Evaluar si se puede guardar después de verificar
                setTimeout(function() {
                    location.reload();
                }, 1000); // Recargar después de 1 segundo (ajusta el tiempo según sea necesario)
            } else {
                $('#codigoAutorizacion_error').text('Código incorrecto. Por favor, intente de nuevo.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al verificar código:', error);
        }
    });
});


    $('#TablaCliente tbody').on('click', '.abrir-editar', function () {
    var data = table.row($(this).parents('tr')).data();
    limpiarFormulario();

    // Cargar los dropdowns con los valores seleccionados
    cargarDropdowns(data);

    // Llenar el formulario con los valores existentes
    $('#Clie_Id').val(data.Clie_Id);
    $('#Clie_Nombre').val(data.Clie_Nombre);
    $('#Clie_Apellido').val(data.Clie_Apellido);
    $('#Clie_DNI').val(data.Clie_DNI);

    var formattedDate = new Date(data.Clie_FechaNac).toISOString().split('T')[0];
    $('#Clie_FechaNac').val(formattedDate);


    if (data.Sexo === 'F') {
        $('input[name="Sexo"][value="F"]').prop('checked', true);
    } else if (data.Sexo === 'M') {
        $('input[name="Sexo"][value="M"]').prop('checked', true);
    }

 

    $('#Muni_Codigo').val(data.Muni_Codigo);
    $('#Esta_Id').val(data.Esta_Id);


// Asegura que data.Clie_esMayorista sea tratado como un booleano explícito
var esMayorista = Boolean(data.Mayoristaa);

// Selecciona el radio button correspondiente
if (esMayorista === true) {
    $('#esMayoristaSi').prop('checked', true);
} else {
    $('#esMayoristaNo').prop('checked', true);
}






    // Mostrar el formulario de edición
    $('.CrearOcultar').hide();
    $('.CrearMostrar').show();
});

});

</script>
</body>
</html>
