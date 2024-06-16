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
                                    <input name="DNI" class="form-control letras" id="DNI" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Contraseña</label>
                                    <input name="Correo" class="form-control letras" id="Correo" />
                                    <span class="text-danger"></span>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Empleado</label>
                                        <select id="Municipio" name="Municipio" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione un Municipio--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Rol</label>
                                        <select id="Cargo" name="Cargo" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione un Cargo--</option>
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

                                <div class="card-body">
                                    <div class="form-row d-flex justify-content-start">
                                        <div class="col-md-2">
                                            <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn" />
                                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>

                                        </div>
                                    </div>
                                </div>
                        </form>
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
                ¿Estás seguro de que deseas eliminar este Empleado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div id="Detalles">
    <div class="row" style="padding: 10px;">
        <div class="col-md-4">
            <strong>DNI</strong>
            <p id="DetallesDNI"></p>
        </div>
        <div class="col-md-4">
            <strong>Empleado</strong>
            <p id="DetallesEmpleado"></p>
        </div>
        <div class="col-md-4">
            <strong>Correo</strong>
            <p id="DetallesCorreo"></p>
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col-md-4">
            <strong>Fecha de Nacimiento</strong>
            <p id="DetallesFechaNac"></p>
        </div>
        <div class="col-md-4">
            <strong>Estado Civil</strong>
            <p id="DetallesEstadoCivil"></p>
        </div>
        <div class="col-md-4">
            <strong>Sexo</strong>
            <p id="DetallesSexo"></p>
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col-md-4">
            <strong>Cargo</strong>
            <p id="DetallesCargo"></p>
        </div>
        <div class="col-md-4">
            <strong>Municipio</strong>
            <p id="DetallesMunicipio"></p>
        </div>
        <div class="col-md-4">
            <strong>Sucursal</strong>
            <p id="DetallesSucursal"></p>
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

<script>
    $(document).ready(function() {
        $('#quickForm').validate({
            rules: {
                DNI: {
                    required: true
                }
            },
            messages: {
                DNI: {
                    required: "Por favor ingrese su Empleado"
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

        sessionStorage.setItem('Empl_Id', "0");
        var table = $('#TablaMarca').DataTable({
            "ajax": {
                "url": "Controllers/EmpleadoController.php",
                "type": "POST",
                "data": function(d) {
                    d.action = 'listarEmpleados';
                },
                "dataSrc": function(json) {
                    return json.data;
                }
            },
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
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
                    "data": "Empl_DNI"
                },
                {
                    "data": "Empleado"
                },
                {
                    "data": "Empl_Correo"
                },
                {
                    "data": "Esta_EstadoCivil"
                },
                {
                    "data": "Sucu_Nombre"
                },
                {
                    "data": "Carg_Cargo"
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
            sessionStorage.setItem('Empl_Id', "0");
        });

        $('#CerrarModal').click(function() {
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
        });

        function cargarDatos() {
            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                type: 'POST',
                data: {
                    action: 'listarDepartamentos'
                },
                success: function(response) {
                    var departamentos = JSON.parse(response);
                    var selectDepartamento = $('#Departamento');
                    selectDepartamento.empty().append('<option selected="selected" value="">--Seleccione un Departamento--</option>');
                    departamentos.forEach(function(departamento) {
                        selectDepartamento.append('<option value="' + departamento.Depa_Codigo + '">' + departamento.Depa_Departamento + '</option>');
                    });
                }
            });

            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                type: 'POST',
                data: {
                    action: 'listarCargos'
                },
                success: function(response) {
                    var cargos = JSON.parse(response);
                    var selectCargo = $('#Cargo');
                    selectCargo.empty().append('<option selected="selected" value="">--Seleccione un Cargo--</option>');
                    cargos.forEach(function(cargo) {
                        selectCargo.append('<option value="' + cargo.Carg_Id + '">' + cargo.Carg_Cargo + '</option>');
                    });
                }
            });

            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                type: 'POST',
                data: {
                    action: 'listarEstadosCiviles'
                },
                success: function(response) {
                    var estadosCiviles = JSON.parse(response);
                    var selectEstadoCivil = $('#EstadoCivil');
                    selectEstadoCivil.empty().append('<option selected="selected" value="">--Seleccione un Estado Civil--</option>');
                    estadosCiviles.forEach(function(estadoCivil) {
                        selectEstadoCivil.append('<option value="' + estadoCivil.Esta_Id + '">' + estadoCivil.Esta_EstadoCivil + '</option>');
                    });
                }
            });

            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                type: 'POST',
                data: {
                    action: 'listarSucursales'
                },
                success: function(response) {
                    var sucursales = JSON.parse(response);
                    var selectSucursal = $('#Sucursal');
                    selectSucursal.empty().append('<option selected="selected" value="">--Seleccione una Sucursal--</option>');
                    sucursales.forEach(function(sucursal) {
                        selectSucursal.append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                    });
                }
            });
        }

        cargarDatos();

        $('#Departamento').change(function() {
            var depaCodigo = $(this).val();
            cargarMunicipios(depaCodigo);
        });

        function cargarMunicipios(depaCodigo) {
            if (depaCodigo) {
                $.ajax({
                    url: 'Controllers/EmpleadoController.php',
                    type: 'POST',
                    data: {
                        action: 'listarMunicipiosPorDepartamento',
                        depaCodigo: depaCodigo
                    },
                    success: function(response) {
                        var municipios = JSON.parse(response);
                        var selectMunicipio = $('#Municipio');
                        selectMunicipio.empty().append('<option selected="selected" value="">--Seleccione un Municipio--</option>');
                        municipios.forEach(function(municipio) {
                            selectMunicipio.append('<option value="' + municipio.Muni_Codigo + '">' + municipio.Muni_Municipio + '</option>');
                        });
                    }
                });
            } else {
                $('#Municipio').empty().append('<option selected="selected" value="">--Seleccione un Municipio--</option>');
            }
        }

        $('#TablaMarca tbody').on('click', '.abrir-eliminar', function() {
            var data = table.row($(this).parents('tr')).data();
            console.log(data);
            var Empl_Id = data.Empl_Id;
            sessionStorage.setItem('Empl_Id', Empl_Id);
            $('#eliminarModal').modal('show');
        });

        $('#confirmarEliminarBtn').click(function() {
            var Empl_Id = sessionStorage.getItem('Empl_Id');
            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                type: 'POST',
                data: {
                    action: 'eliminar',
                    Empl_Id: Empl_Id
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
                        sessionStorage.setItem('Empl_Id', "0");
                    } else {
                        alert('Error al eliminar empleado.');
                    }
                },
                error: function() {
                    alert('Error en la comunicación con el servidor.');
                }
            });
        });

        $('#guardarBtn').click(function() {
            if ($('#quickForm').valid()) {
                var empleadoData = {
                    DNI: $('#DNI').val(),
                    Correo: $('#Correo').val(),
                    Nombres: $('#Nombres').val(),
                    Apellidos: $('#Apellidos').val(),
                    FechaNac: $('#FechaNac').val(),
                    Departamento: $('#Departamento').val(),
                    Municipio: $('#Municipio').val(),
                    Cargo: $('#Cargo').val(),
                    Sucursal: $('#Sucursal').val(),
                    EstadoCivil: $('#EstadoCivil').val(),
                    Sexo: $('input[name="Sexo"]:checked').val()
                };
                var Valor = sessionStorage.getItem('Empl_Id');
                var InsertarOActualizar = Valor == "0";

                console.log(empleadoData, Valor);

                $.ajax({
                    url: 'Controllers/EmpleadoController.php',
                    type: 'POST',
                    data: {
                        action: InsertarOActualizar ? 'insertar' : 'actualizar',
                        Empl_Id: Valor,
                        Nombres: empleadoData.Nombres,
                        Apellidos: empleadoData.Apellidos,
                        Sexo: empleadoData.Sexo,
                        FechaNac: empleadoData.FechaNac,
                        DNI: empleadoData.DNI,
                        Municipio: empleadoData.Municipio,
                        Sucursal: empleadoData.Sucursal,
                        EstadoCivil: empleadoData.EstadoCivil,
                        Cargo: empleadoData.Cargo,
                        Correo: empleadoData.Correo,
                        Empl_UsuarioModificacion: 1,
                        Empl_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
                    },
                    success: function(response) {
                        console.log(response);
                        if (response == 1) {
                            $('#quickForm')[0].reset();
                            iziToast.success({
                                title: 'Éxito',
                                message: 'Empleado guardado con éxito',
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
                                message: 'No se pudo guardar el empleado',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function() {
                        alert('Error en la comunicación con el servidor.');
                    }
                });
            }
        });


        $('#TablaMarca tbody').on('click', '.abrir-editar', function() {
            var data = table.row($(this).parents('tr')).data();
            sessionStorage.setItem('Empl_Id', data.Empl_Id);

            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                method: 'POST',
                data: {
                    action: 'buscar',
                    Empl_Id: data.Empl_Id
                },
                success: function(response) {
                    var data = JSON.parse(response).data[0];
                    $('#DNI').val(data.Empl_DNI);
                    $('#Correo').val(data.Empl_Correo);
                    $('#Nombres').val(data.Empl_Nombre);
                    $('#Apellidos').val(data.Empl_Apellido);
                    $('#FechaNac').val(data.Empl_FechaNac);
                    $('#Departamento').val(data.Depa_Codigo).trigger('change');
                    setTimeout(function() {
                        $('#Municipio').val(data.Muni_Codigo);
                    }, 50);
                    $('#Cargo').val(data.Carg_Id).trigger('change');
                    $('#Sucursal').val(data.Sucu_Id).trigger('change');
                    $('#EstadoCivil').val(data.Esta_Id).trigger('change');
                    $('input[name="Sexo"][value="' + data.Empl_Sexo + '"]').prop('checked', true);
                    $('.CrearOcultar').hide();
                    $('.CrearMostrar').show();
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        $('#TablaMarca tbody').on('click', '.abrir-detalles', function() {
            var data = table.row($(this).parents('tr')).data();
            var Empl_Id = data.Empl_Id;
            $('#Detalles').show();
            $('.CrearOcultar').hide();
            $('.CrearMostrar').hide();

            $.ajax({
                url: 'Controllers/EmpleadoController.php',
                method: 'POST',
                data: {
                    action: 'buscar',
                    Empl_Id: Empl_Id
                },
                success: function(response) {
                    var data = JSON.parse(response).data[0];
                    $('#DetallesDNI').text(data.Empl_DNI);
                    $('#DetallesEmpleado').text(data.Empl_Nombre + ' ' + data.Empl_Apellido);
                    $('#DetallesCorreo').text(data.Empl_Correo);
                    $('#DetallesSexo').text(data.Sexo);
                    $('#DetallesFechaNac').text(data.Empl_FechaNac);
                    $('#DetallesMunicipio').text(data.Muni_Municipio);
                    $('#DetallesEstadoCivil').text(data.Esta_EstadoCivil);
                    $('#DetallesCargo').text(data.Carg_Cargo);
                    $('#DetallesSucursal').text(data.Sucu_Nombre);
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