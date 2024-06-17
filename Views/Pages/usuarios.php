<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center"><b>Usuarios</b></h3>
                </div>
                <div class="card-body">
                    <div class="CrearOcultar">
                        <p class="btn btn-primary" id="AbrirModal">Nuevo</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="TablaMarca">
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Administrador</th>
                                        <th>Empleado</th>
                                        <th>Rol</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="CrearMostrar">
                        <form id="quickForm">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="control-label">Usuario</label>
                                    <input name="Usuario" class="form-control letras" id="Usuario" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-6 contraseña-container">
                                    <label class="control-label">Contraseña</label>
                                    <input name="Contraseña" class="form-control letras" id="Contraseña" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Empleado</label>
                                        <select id="Empleado" name="Empleado" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione un Empleado--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <select id="Rol" name="Rol" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione un Rol--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="Administrador">Administrador</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="Administrador">
                                        <label class="custom-control-label" for="Administrador"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row mt-3">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-primary" id="guardarBtn">Guardar</button>
                                    <a id="CerrarModal" class="btn btn-secondary ml-2" style="color:white">Volver</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="Detalles">
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-4">
                            <strong>Usuario</strong>
                            <p id="DetallesUsuario"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Empleado</strong>
                            <p id="DetallesEmpleado"></p>
                        </div>
                        <div class="col-md-4">
                            <strong>Rol</strong>
                            <p id="DetallesRol"></p>
                        </div>
                    </div>
                    <div class="row" style="padding: 10px;">
                        <div class="col-md-4">
                            <strong>Administrador</strong>
                            <p id="DetallesAdministrador"></p>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <h5>Auditoría</h5>
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
                                        <td><label for="" id="DetallesUsuarioCreacion"></label></td>
                                        <td><label for="" id="DetallesFechaCreacion"></label></td>
                                    </tr>
                                    <tr>
                                        <td>Modificar</td>
                                        <td><label for="" id="DetallesUsuarioModificacion"></label></td>
                                        <td><label for="" id="DetallesFechaModificacion"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-end m-3">
                        <a class="btn btn-secondary" style="color:white" id="VolverDetalles">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
                ¿Estás seguro de que deseas eliminar este Usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .hidden {
        display: none;
    }
</style>

<script>
    $(document).ready(function() {
        $('#quickForm').validate({
            rules: {
                Usuario: {
                    required: true
                }
            },
            messages: {
                Usuario: {
                    required: "Por favor ingrese el nombre de usuario"
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.col-md-6').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        sessionStorage.setItem('Usua_Id', "0");
        var table = $('#TablaMarca').DataTable({
            "ajax": {
                "url": "Controllers/UsuarioController.php",
                "type": "POST",
                "data": function(d) {
                    d.action = 'listarUsuarios';
                },
                "dataSrc": function(json) {
                    console.log('Respuesta del servidor:', json);
                    if (json.error) {
                        console.error('Error:', json.error);
                        alert('Error al listar usuarios: ' + json.error);
                        return [];
                    } else {
                        return json.data;
                    }
                }
            },
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "columns": [{
                    "data": "Usua_Usuario"
                },
                {
                    "data": "Usua_Administrador"
                },
                {
                    "data": "Empleado"
                },
                {
                    "data": "Role_Rol"
                },
                {
                    "data": null,
                    "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</a> <a class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i>Detalles</a> <button class='btn btn-danger btn-sm abrir-eliminar'><i class='fas fa-eraser'></i> Eliminar</button>"
                }
            ]
        });

        $('.CrearOcultar').show();
        $('.CrearMostrar').hide();
        $('#Detalles').hide();

        $('#AbrirModal').click(function() {
            $('.CrearOcultar').hide();
            $('.CrearMostrar').show();
            sessionStorage.setItem('Usua_Id', "0");
            $('.contraseña-container').removeClass('hidden');
        });

        $('#CerrarModal').click(function() {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    $('#quickForm')[0].reset(); 
});


        function cargarDatos() {
            $.ajax({
                url: 'Controllers/UsuarioController.php',
                type: 'POST',
                data: {
                    action: 'listarEmpleados'
                },
                success: function(response) {
                    var empleados = JSON.parse(response);
                    var selectEmpleado = $('#Empleado');
                    selectEmpleado.empty().append('<option selected="selected" value="">--Seleccione un Empleado--</option>');
                    empleados.forEach(function(empleado) {
                        selectEmpleado.append('<option value="' + empleado.Empl_Id + '">' + empleado.Empleado + '</option>');
                    });
                }
            });

            $.ajax({
                url: 'Controllers/UsuarioController.php',
                type: 'POST',
                data: {
                    action: 'listarRoles'
                },
                success: function(response) {
                    var roles = JSON.parse(response);
                    var selectRol = $('#Rol');
                    selectRol.empty().append('<option selected="selected" value="">--Seleccione un Rol--</option>');
                    roles.forEach(function(rol) {
                        selectRol.append('<option value="' + rol.Role_Id + '">' + rol.Role_Rol + '</option>');
                    });
                }
            });
        }

        cargarDatos();

        $('#TablaMarca tbody').on('click', '.abrir-eliminar', function() {
            var data = table.row($(this).parents('tr')).data();
            console.log('Datos para eliminar:', data);

            if (!data.Usua_Id) {
                console.error('Usua_Id está vacío o indefinido:', data);
                return;
            }

            sessionStorage.setItem('Usua_Id', data.Usua_Id);
            $('#eliminarModal').modal('show');
        });

        $('#confirmarEliminarBtn').click(function() {
            var Usua_Id = sessionStorage.getItem('Usua_Id');
            if (!Usua_Id) {
                console.error('Usua_Id está vacío o indefinido:', Usua_Id);
                return;
            }

            $.ajax({
                url: 'Controllers/UsuarioController.php',
                type: 'POST',
                data: {
                    action: 'eliminar',
                    Usua_Id: Usua_Id
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
                        $('#TablaMarca').DataTable().ajax.reload();
                        $('#eliminarModal').modal('hide');
                        sessionStorage.setItem('Usua_Id', "0");
                    } else {
                        alert('Error al eliminar usuario.');
                    }
                },
                error: function() {
                    alert('Error en la comunicación con el servidor.');
                }
            });
        });

        $('#guardarBtn').click(function() {
            if ($('#quickForm').valid()) {
                var usuarioData = {
                    Usuario: $('#Usuario').val() ? $('#Usuario').val() : 'sua',
                    Contraseña: $('#Contraseña').val() ? $('#Contraseña').val() : 'sua',
                    Administrador: $('#Administrador').is(':checked') ? 1 : 0,
                    Empleado: $('#Empleado').val() ? $('#Empleado').val() : 4,
                    Rol: $('#Rol').val() ? $('#Rol').val() : 7
                };
                var Valor = sessionStorage.getItem('Usua_Id');
                var InsertarOActualizar = Valor == "0";

                console.log('Datos a enviar:', usuarioData, Valor);

                $.ajax({
                    url: 'Controllers/UsuarioController.php',
                    type: 'POST',
                    data: {
                        action: InsertarOActualizar ? 'insertar' : 'actualizar',
                        Usua_Id: Valor,
                        Usuario: usuarioData.Usuario,
                        Contraseña: InsertarOActualizar ? usuarioData.Contraseña : '', 
                        Administrador: usuarioData.Administrador,
                        Empleado: usuarioData.Empleado,
                        Rol: usuarioData.Rol,
                        Usua_UsuarioModificacion: 1,
                        Usua_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
                    },
                    success: function(response) {
                        console.log('Respuesta del servidor:', response);
                        if (response == 1) {
                            $('#quickForm')[0].reset();
                            iziToast.success({
                                title: 'Éxito',
                                message: 'Usuario guardado con éxito',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                            $('#TablaMarca').DataTable().ajax.reload();
                            $('.CrearOcultar').show();
                            $('.CrearMostrar').hide();
                        } else {
                            iziToast.error({
                                title: 'Error',
                                message: 'No se pudo guardar el usuario: ' + response,
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud:', error);
                        alert('Error en la comunicación con el servidor.');
                    }
                });
            }
        });

        $('#TablaMarca tbody').on('click', '.abrir-editar', function() {
            var data = table.row($(this).parents('tr')).data();
            console.log('Datos para editar:', data);

            if (!data.Usua_Id) {
                console.error('Usua_Id está vacío o indefinido:', data);
                return;
            }

            sessionStorage.setItem('Usua_Id', data.Usua_Id);

            $.ajax({
                url: 'Controllers/UsuarioController.php',
                method: 'POST',
                data: {
                    action: 'buscar',
                    Usua_Id: data.Usua_Id
                },
                success: function(response) {
                    console.log('Buscar Response:', response);
                    var parsedResponse = JSON.parse(response);
                    if (parsedResponse.error) {
                        console.error('Error:', parsedResponse.error);
                    } else {
                        var data = parsedResponse.data[0];
                        $('#Usuario').val(data.Usua_Usuario);
                        $('#Empleado').val(data.Empl_Id).trigger('change');
                        $('#Rol').val(data.Role_Id).trigger('change');
                        $('#Administrador').prop('checked', data.Usua_Administrador == 1);
                        $('.CrearOcultar').hide();
                        $('.CrearMostrar').show();
                        $('.contraseña-container').addClass('hidden'); 
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#TablaMarca tbody').on('click', '.abrir-detalles', function() {
            var data = table.row($(this).parents('tr')).data();

            var Usua_Id = data.Usua_Id;
            $('#Detalles').show();
            $('.CrearOcultar').hide();
            $('.CrearMostrar').hide();

            $.ajax({
                url: 'Controllers/UsuarioController.php',
                method: 'POST',
                data: {
                    action: 'buscar',
                    Usua_Id: Usua_Id
                },
                success: function(response) {
                    var data = JSON.parse(response).data[0];
                    console.log(data);
                    $('#DetallesUsuario').text(data.Usua_Usuario);
                    $('#DetallesEmpleado').text(data.Empleado);
                    $('#DetallesRol').text(data.Role_Rol);
                    $('#DetallesAdministrador').text(data.Usua_Administrador == 1 ? 'Sí' : 'No');
                    $('#DetallesUsuarioCreacion').text(data.UsuarioCreacion);
                    $('#DetallesFechaCreacion').text(data.FechaCreacion);
                    $('#DetallesUsuarioModificacion').text(data.UsuarioModificacion);
                    $('#DetallesFechaModificacion').text(data.FechaModificacion);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });


        $('#VolverDetalles').click(function() {
            $('#Detalles').hide();
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
        });
    });
</script>
