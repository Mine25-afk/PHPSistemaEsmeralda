<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Usuarios</title>
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

        .blinking-button {
            animation: blinking 1.5s infinite;
        }

        @keyframes blinking {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h2 class="text-center" style="font-size: 90px !important">Usuarios</h2>
            <div class="CrearOcultar" style="position:relative; top:-30px">
                <button class="btn btn-primary" id="AbrirModal">Nuevo</button>
                <div class="table-responsive">
                    <br>
                    <table class="table table-striped table-hover" id="TablaUsuario">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuario</th>
                                <th>Administrador</th>
                                <th>Empleado</th>
                                <th>Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="CrearMostrar">
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <a href="#" id="Regresar" style="color: black;" class="btn btn-link">Regresar</a>
                    </div>
                    <form id="usuarioForm">
                        <hr>
                        <input type="hidden" name="Usua_Id" id="Usua_Id">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="control-label">Usuario</label>
                                <input name="Usua_Usuario" class="form-control letras" id="Usua_Usuario" required />
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-6 contraseña-container">
                                <label class="control-label">Contraseña</label>
                                <input name="Usua_Contraseña" type="password" class="form-control letras" id="Usua_Contraseña" required />
                                <span class="text-danger"></span>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Empleado</label>
                                <select name="Empl_Id" class="form-control" id="Empl_Id" required></select>
                                <div class="error-message" id="Empl_Id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Roles</label>
                                <select name="Role_Id" class="form-control" id="Role_Id" required></select>
                                <div class="error-message" id="Role_Id_error"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label" for="Administrador">Administrador</label>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="Administrador">
                                    <label class="custom-control-label" for="Administrador"></label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row d-flex justify-content-end">
                                <div class="col-auto">
                                    <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn">
                                </div>
                                <div class="col-auto">
                                    <a id="CerrarModal" class="btn btn-secondary" style="color: white;">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Collapse Detalles -->
            <div class="CrearDetalles collapse" id="detallesCollapse">
                <div class="d-flex justify-content-end">
                    <a href="#" id="CerrarDetalles" style="color: black;" class="btn btn-link">Regresar</a>
                </div>
                <div class="card card-body">
                    <h5>Detalles de Usuario</h5>
                    <div id="Detalles">
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-4" style="font-weight: 700;">Usuario</div>
                            <div class="col-md-4" style="font-weight: 700;">Administrador</div>
                            <div class="col-md-4" style="font-weight: 700;">Empleado</div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-4">
                                <label for="" id="detallesUsuario"></label>
                            </div>
                            <div class="col-md-4">
                                <label for="" id="detallesAdministrador"></label>
                            </div>
                            <div class="col-md-4">
                                <label for="" id="detallesEmpleado"></label>
                            </div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-4" style="font-weight: 700;">Rol</div>
                        </div>
                        <div class="row" style="padding: 10px;">
                            <div class="col-md-4">
                                <label for="" id="detallesRol"></label>
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
                                            <th>Usua_Usuario</th>
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
                            <a id="CerrarDetalles" class="btn btn-secondary" style="color: white;">Cancelar</a>
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
                            ¿Estás seguro de que deseas eliminar este Usua_Usuario?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">SI</button>
                            <button type="button" class="btn btn-secondary" style="color: white;" data-dismiss="modal">NO</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#menu-generales").addClass('menu-open');
            $("#linkgenerales").addClass('active');
            $("#linkclientes").addClass('active');

            var table = $('#TablaUsuario').DataTable({
                "ajax": {
                    "url": "Services/UsuarioService.php",
                    "type": "POST",
                    "data": function (d) {
                        d.action = 'listarUsuarios';
                    },
                    "dataSrc": function (json) {
                        return json.data;
                    }
                },
                "columns": [{
                    "data": null
                },
                {
                    "data": "Usua_Usuario"
                },
                {
                    "data": "Usua_Administradores"
                },
                {
                    "data": "Empleado"
                },
                {
                    "data": "Role_Rol"
                },
                {
                    "data": null,
                    "defaultContent": `
                        <div class='text-center'>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cogs"></i> Acciones
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item abrir-editar" href="#"><i class="fas fa-edit"></i> Editar</a>
                                    <a class="dropdown-item abrir-detalles" href="#"><i class="fas fa-info-circle"></i> Detalles</a>
                                    <a class="dropdown-item abrir-eliminar" href="#"><i class="fas fa-trash-alt"></i> Eliminar</a>
                                </div>
                            </div>
                        </div>
                    `
                }],
                "createdRow": function (row, data, dataIndex) {
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });

            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
            $('.CrearDetalles').hide();

            function limpiarFormulario() {
                $('#usuarioForm').trigger('reset');
                $('.error-message').text('');
                $('#Usua_Id').val('');
            }

            async function cargarDropdowns(selectedData = {}) {
                try {
                    const municipios = await $.ajax({
                        url: 'Services/UsuarioService.php',
                        type: 'POST',
                        data: {
                            action: 'listarEmpleados'
                        }
                    });
                    const estadosCiviles = await $.ajax({
                        url: 'Services/UsuarioService.php',
                        type: 'POST',
                        data: {
                            action: 'listarRoles'
                        }
                    });

                    const empleadosDropdown = $('#Empl_Id');
                    empleadosDropdown.empty();
                    JSON.parse(municipios).data.forEach(empleado => {
                        empleadosDropdown.append('<option value="' + empleado.Empl_Id + '">' + empleado.Empleado + '</option>');
                    });
                    if (selectedData.Empl_Id) {
                        $('#Empl_Id').val(selectedData.Empl_Id);
                    }

                    const RolesDropdown = $('#Role_Id');
                    RolesDropdown.empty();
                    JSON.parse(estadosCiviles).data.forEach(rol => {
                        RolesDropdown.append('<option value="' + rol.Role_Id + '">' + rol.Role_Rol + '</option>');
                    });
                    if (selectedData.Role_Id) {
                        $('#Role_Id').val(selectedData.Role_Id);
                    }
                } catch (error) {
                    console.error('Error cargando dropdowns:', error);
                }
            }

            $('#AbrirModal').click(function () {
                console.log('Botón Nuevo clickeado');
                limpiarFormulario();
                $('.CrearOcultar').hide();
                $('.CrearMostrar').show();
                cargarDropdowns();
            });

            $('#Regresar').click(function () {
                limpiarFormulario();
                $('.CrearOcultar').show();
                $('.CrearMostrar').hide();
            });

            $('#CerrarModal').click(function () {
                limpiarFormulario();
                $('.CrearOcultar').show();
                $('.CrearMostrar').hide();
                $('#botonIngresarCodigoContainer').hide();
            });

            $('#CerrarDetalles').click(function () {
                $('.CrearOcultar').show();
                $('.CrearDetalles').hide();
            });

            $('#guardarBtn').click(function () {
                console.log('Botón Guardar clickeado');
                $('.error-message').text('');
                var isValid = true;

                var nombre = $('#Usua_Usuario').val();
                console.log('Valor de Usua_Usuario:', nombre);
                if (!nombre || nombre.trim() === '') {
                    $('#Usua_Usuario_error').text('Este campo es requerido');
                    isValid = false;
                }

                var contraseña = $('#Usua_Contraseña').val();
                console.log('Valor de Usua_Contraseña:', contraseña);
                if (!contraseña || contraseña.trim() === '') {
                    $('#Usua_Contraseña_error').text('Este campo es requerido');
                    isValid = false;
                }

                var municipio = $('#Empl_Id').val();
                if (!municipio) {
                    $('#Empl_Id_error').text('Este campo es requerido');
                    isValid = false;
                }

                var estado = $('#Role_Id').val();
                if (!estado) {
                    $('#Role_Id_error').text('Este campo es requerido');
                    isValid = false;
                }

                var administrador = $('#Administrador').prop('checked') ? 1 : 0;

                if (isValid) {
                    var UsuaData = new FormData();
                    UsuaData.append('action', $('#Usua_Id').val() ? 'actualizar' : 'insertar');
                    UsuaData.append('Usua_Id', $('#Usua_Id').val());
                    UsuaData.append('Usua_Usuario', $('#Usua_Usuario').val());
                    UsuaData.append('Usua_Contraseña', $('#Usua_Contraseña').val());
                    UsuaData.append('Usua_Administrador', administrador);
                    UsuaData.append('Empl_Id', $('#Empl_Id').val());
                    UsuaData.append('Role_Id', $('#Role_Id').val());
                    UsuaData.append('Usua_UsuarioCreacion', 1);
                    UsuaData.append('Usua_FechaCreacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
                    UsuaData.append('Usua_UsuarioModificacion', 1);
                    UsuaData.append('Usua_FechaModificacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
                    console.log('Datos a enviar:', UsuaData);

                    $.ajax({
                        url: 'Services/UsuarioService.php',
                        type: 'POST',
                        data: UsuaData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
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
                                    setTimeout(function () {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    iziToast.error({
                                        title: 'Error',
                                        message: 'Error al insertar/actualizar Usuario. ' + (response.error ? response.error : ''),
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
                        error: function (xhr, status, error) {
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

            $('#TablaUsuario tbody').on('click', '.abrir-eliminar', function () {
                var data = table.row($(this).parents('tr')).data();
                console.log(data);
                var Usua_Id = data.Usua_Id;
                sessionStorage.setItem('Usua_Id', Usua_Id);
                $('#eliminarModal').modal('show');
            });

            $('#confirmarEliminarBtn').click(function () {
                var Usua_Id = sessionStorage.getItem('Usua_Id');
                $.ajax({
                    url: 'Services/UsuarioService.php',
                    type: 'POST',
                    data: {
                        action: 'eliminar',
                        Usua_Id: Usua_Id
                    },
                    success: function (response) {
                        if (response == 1) {
                            iziToast.success({
                                title: 'Éxito',
                                message: 'Eliminado con éxito',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                            $('#TablaUsuario').DataTable().ajax.reload();
                            $('#eliminarModal').modal('hide');
                            sessionStorage.setItem('Usua_Id', "0");
                        } else {
                            iziToast.success({
                                title: 'Éxito',
                                message: 'Eliminado con éxito',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                            $('#TablaUsuario').DataTable().ajax.reload();
                            $('#eliminarModal').modal('hide');
                            sessionStorage.setItem('Usua_Id', "0");
                        }
                    },
                    error: function () {
                 
                    }
                });
            });

            $('#TablaUsuario tbody').on('click', '.abrir-detalles', function () {
                var data = table.row($(this).parents('tr')).data();
                $('#detallesUsuario').text(data.Usua_Usuario);
                $('#detallesEmpleado').text(data.Empleado);
                $('#detallesRol').text(data.Role_Rol);
                $('#detallesMayorista').text(data.Clie_esMayorista);
                $('#detallesAdministrador').text(data.Usua_Administrador);
                $('#detallesUsuarioCreacion').text(data.UsuarioCreacion);
                $('#detallesFechaCreacion').text(data.Usua_FechaCreacion);
                $('#detallesUsuarioModificacion').text(data.UsuarioModificacion);
                $('#detallesFechaModificacion').text(data.Usua_FechaModificacion);

                $('.CrearOcultar').hide();
                $('.CrearDetalles').show();
            });

            $('#TablaUsuario tbody').on('click', '.abrir-editar', function () {
                var data = table.row($(this).parents('tr')).data();
                limpiarFormulario();
                cargarDropdowns(data);
                $('#Usua_Id').val(data.Usua_Id);
                $('#Usua_Usuario').val(data.Usua_Usuario);
                $('#Usua_Contraseña').val(data.Usua_Contraseña);
                if (data.Usua_Administrador === '1') {
                    $('#Administrador').prop('checked', true);
                }
                $('#Empl_Id').val(data.Empl_Id);
                $('#Role_Id').val(data.Role_Id);

                $('.CrearOcultar').hide();
                $('.CrearMostrar').show();
            });
        });
    </script>
</body>

</html>
