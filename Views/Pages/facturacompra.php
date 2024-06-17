<div class="container-fluid">
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center"><b>Factura Compra</b></h3>
                </div>
                <div class="card-body">
                    <div class="CrearOcultar">
                        <p class="btn btn-primary" id="AbrirModal"> Nuevo</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="TablaMarca">
                                <thead>
                                    <tr>
                                        <th>Proveedor</th>
                                        <th>Metodo de Pago</th>
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
                                    <div class="form-group">
                                        <label>Proveedor</label>
                                        <select id="Proveedor" name="Proveedor" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione un Proveedor--</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Sucursal</label>
                                        <select id="Sucursal" name="Sucursal" class="form-control select2" style="width: 100%;">
                                            <option selected="selected" value="">--Seleccione una Sucursal--</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <label for="">Método de Pago</label>
                                <div class="form-row d-flex justify-content-start">
                                    <div class="col-md-7">
                                        <input type="button" value="Efectivo" class="btn btn-outline-success" id="guardarBtn" />
                                        <a id="CerrarModal" class="btn btn-outline-info">Tarjeta de Crédito</a>
                                        <a id="CerrarModal" class="btn btn-outline-danger">Pago en Línea</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row d-flex justify-content-start">
                                    <div class="col-md-2">
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



<script>
    $(document).ready(function() {
        $('#quickForm').validate({
            rules: {
                DNI: {
                    required: true
                },

            },
            messages: {
                DNI: {
                    required: "Por favor ingrese su DNI"
                },

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

        sessionStorage.setItem('FaCE_Id', "0");
        var table = $('#TablaMarca').DataTable({
            "ajax": {
                "url": "Controllers/FacturaCompraController.php",
                "type": "POST",
                "data": function(d) {
                    d.action = 'listarFacturaCompras';
                },
                "dataSrc": function(json) {
                    console.log('Respuesta del servidor:', json);
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
                    "data": "nombreProveedor"
                },
                {
                    "data": "mepa_Metodo"
                },
                {
                    "data": null,
                    "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</a> "
                }
            ]
        });

        $('.CrearOcultar').show();
        $('.CrearMostrar').hide();

        $('#AbrirModal').click(function() {
            $('.CrearOcultar').hide();
            $('.CrearMostrar').show();
            sessionStorage.setItem('FaCE_Id', "0");
        });

        $('#CerrarModal').click(function() {
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
            // $('#quickForm')[0].reset();
        });


        function cargarDatos() {
            $.ajax({
                url: 'Controllers/FacturaCompraController.php',
                type: 'POST',
                data: {
                    action: 'listarProveedores'
                },
                success: function(response) {
                    var proveedores = JSON.parse(response);
                    var selectProveedor = $('#Proveedor');
                    selectProveedor.empty().append('<option selected="selected" value="">--Seleccione un Proveedor--</option>');
                    proveedores.forEach(function(proveedor) {
                        selectProveedor.append('<option value="' + proveedor.Prov_Id + '">' + proveedor.Prov_Proveedor + '</option>');
                    });
                }
            });

            $.ajax({
                url: 'Controllers/FacturaCompraController.php',
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


        $('#TablaMarca tbody').on('click', '.abrir-editar', function() {
            var data = table.row($(this).parents('tr')).data();
            sessionStorage.setItem('FaCE_Id', data.FaCE_Id);

            $.ajax({
                url: 'Controllers/FacturaCompraController.php',
                method: 'POST',
                data: {
                    action: 'buscar',
                    FaCE_Id: data.FaCE_Id
                },
                // success: function(response) {
                //     var data = JSON.parse(response).data[0];
                //     $('#DNI').val(data.Empl_DNI);
                //     $('#Correo').val(data.Empl_Correo);
                //     $('#Nombres').val(data.Empl_Nombre);
                //     $('#Apellidos').val(data.Empl_Apellido);
                //     var formattedDate = new Date(data.Empl_FechaNac).toISOString().split('T')[0];
                //     $('#FechaNac').val(formattedDate);
                //     $('#Proveedor').val(data.Carg_Id).trigger('change');
                //     $('#Sucursal').val(data.Sucu_Id).trigger('change');
                //     $('.CrearOcultar').hide();
                //     $('.CrearMostrar').show();
                // },
                // error: function(error) {
                //     console.error('Error:', error);
                // }
            });
        });

    });
</script>