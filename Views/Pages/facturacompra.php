<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #e2c8c8;
            color: black;
        }

        .form-row {
            justify-content: center;
            margin: 0px 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-outline-success {
            background-color: white;
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-info {
            background-color: white;
            border-color: #17a2b8;
            color: #17a2b8;
        }

        .btn-outline-danger {
            background-color: white;
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-selected-success {
            background-color: #28a745 !important;
            color: white !important;
        }

        .btn-selected-info {
            background-color: #17a2b8 !important;
            color: white !important;
        }

        .btn-selected-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }

        .btn-outline-success.deselected {
            background-color: white !important;
            color: #28a745 !important;
        }

        .btn-outline-info.deselected {
            background-color: white !important;
            color: #17a2b8 !important;
        }

        .btn-outline-danger.deselected {
            background-color: white !important;
            color: #dc3545 !important;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <h2 class="text-center" style="font-size: 90px !important">Factura Compra</h2>

                    <div class="card-body">
                        <div class="CrearOcultar" style="position:relative; top:-30px">
                            <p class="btn btn-primary" id="AbrirModal"> Nuevo</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="TablaFacturaCompra">
                                    <thead>
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Metodo de Pago</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="CrearMostrar">
                            <form id="FacturaCompraForm" style="width: 100%">
                                <div class="form-row" style="justify-content: center; margin: 0px 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Proveedor</label>
                                            <select id="Proveedor" name="Proveedor" class="form-control select2" style="width: 100%;">
                                                <option selected="selected" value="">--Seleccione--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sucursal</label>
                                            <select id="Sucursal" name="Sucursal" class="form-control select2" style="width: 100%;">
                                                <option selected="selected" value="">--Seleccione--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <label for="">Método de Pago</label>
                                    <div class="form-row d-flex justify-content-start">
                                        <div class="col-md-7">
                                            <input type="button" value="Efectivo" class="btn btn-outline-info metodo-pago metodo-efectivo deselected" />
                                            <input type="button" value="Tarjeta de Crédito" class="btn btn-outline-info metodo-pago metodo-tarjeta deselected" />
                                            <input type="button" value="Pago en Línea" class="btn btn-outline-info metodo-pago metodo-online deselected" />
                                        </div>
                                    </div>
                                </div>



                                <div class="card-body">
                                    <div class="form-row d-flex justify-content-start">
                                        <div class="col-md-12">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Categoría</th>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Compra</th>
                                                        <th>Precio Venta</th>
                                                        <th>Precio Mayorista</th>
                                                        <th>Eliminar</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="detalleFactura">
                                                    <tr>
                                                        <td>
                                                            <p id="categoria"></p>
                                                        </td>
                                                        <td><input type="text" class="form-control" name="producto" /></td>
                                                        <td><input type="number" class="form-control" name="cantidad" /></td>
                                                        <td><input type="text" class="form-control" id="precio_compra" name="precio_compra" oninput="validateNumber(this)" /></td>
                                                        <td>
                                                            <p id="precio_venta">0.00</p>
                                                        </td>
                                                        <td>
                                                            <p id="precio_mayorista">0.00</p>
                                                        </td>
                                                        <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash-alt"></i></button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="card-body">
                                    <div class="form-row d-flex justify-content-end">
                                        <div class="col-auto">

                                            <input type="button" value="Confirmar" class="btn btn-primary" id="confirmarBtn" />
                                        </div>
                                        <div class="col-auto">
                                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
                                        </div>

                                    </div>
                                </div>
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
        $('.select2').select2();

        function validateNumber(input) {
            input.value = input.value.replace(/[^0-9.,]/g, '');
        }

        function eliminarFila(button) {
            var row = button.closest('tr');
            row.remove();
        }
        $(this).closest('tr').find('input[name="precio_compra"]').val('0.00');
        $(this).closest('tr').find('input[name="cantidad"]').val('1');

        $(document).ready(function() {

            $('input[name="cantidad"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $('.metodo-pago').click(function() {
                $('.metodo-pago').removeClass('btn-selected-success btn-selected-info btn-selected-danger').addClass('deselected');
                $(this).removeClass('deselected');

                // if ($(this).hasClass('metodo-efectivo')) {
                //     $(this).addClass('btn-selected-success');
                // } else if ($(this).hasClass('metodo-tarjeta')) {
                $(this).addClass('btn-selected-info');
                // } else if ($(this).hasClass('metodo-online')) {
                //     $(this).addClass('btn-selected-danger');
                // }
            });

            $(document).ready(function() {
                $('input[name="producto"]').autocomplete({
                    source: function(request, response) {
                        var term = request.term.toLowerCase();
                        var ajaxDataJoyas = {
                            action: 'listarJoyasAutoCompletado',
                            term: term
                        };
                        var ajaxDataMaquillajes = {
                            action: 'listarMaquillajesAutoCompletado',
                            term: term
                        };

                        if (/^[a-zA-Z]+/.test(term)) {
                            $.when(
                                $.ajax({
                                    url: 'Controllers/FacturaCompraController.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: ajaxDataJoyas
                                }),
                                $.ajax({
                                    url: 'Controllers/FacturaCompraController.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: ajaxDataMaquillajes
                                })
                            ).then(function(joyasData, maquillajesData) {
                                var combinedData = joyasData[0].concat(maquillajesData[0]);
                                var filteredData = combinedData.filter(function(item) {
                                    var codigo = (item.Joya_Codigo || item.Maqu_Codigo).toLowerCase();
                                    var nombre = (item.Joya_Nombre || item.Maqu_Nombre).toLowerCase();
                                    return codigo.indexOf(term) !== -1 || nombre.indexOf(term) !== -1;
                                });

                                response($.map(filteredData, function(item) {
                                    return {
                                        label: item.Joya_Nombre ? item.Joya_Nombre + ' - ' + item.Joya_Codigo : item.Maqu_Nombre + ' - ' + item.Maqu_Codigo,
                                        value: item.Joya_Codigo || item.Maqu_Codigo,
                                        data: item
                                    };
                                }));
                            });
                        } else if (/^[0-9]+/.test(term)) {
                            $(this).closest('tr').find('#categoria').text('Maquillaje');
                            $.ajax({
                                url: 'Controllers/FacturaCompraController.php',
                                type: 'POST',
                                dataType: 'json',
                                data: ajaxDataMaquillajes,
                                success: function(data) {
                                    var filteredData = data.filter(function(item) {
                                        var codigo = (item.Maqu_Codigo).toLowerCase();
                                        return codigo.indexOf(term) !== -1;
                                    });

                                    response($.map(filteredData, function(item) {
                                        return {
                                            label: item.Maqu_Nombre + ' - ' + item.Maqu_Codigo,
                                            value: item.Maqu_Codigo,
                                            data: item
                                        };
                                    }));
                                }
                            });
                        }
                    },
                    minLength: 1,
                    select: function(event, ui) {
                        var selectedItem = ui.item.data;
                        console.log(selectedItem);
                        let preciom = selectedItem.Mayor;
                        let preciov = selectedItem.Venta;
                        console.log(preciov);
                        $(this).closest('tr').find('#precio_mayorista').text(preciom);
                        $(this).closest('tr').find('#precio_venta').text(preciov);
                        $(this).closest('tr').find('input[name="precio_compra"]').val(selectedItem.Joya_PrecioCompra || selectedItem.Maqu_PrecioCompra);
                        if (selectedItem.Joya_Codigo) {
                            $(this).closest('tr').find('#categoria').text('Joya');
                        } else {
                            $(this).closest('tr').find('#categoria').text('Maquillaje');
                        }
                    }
                });

                $('input[name="producto"]').on('blur', function() {
                    var term = $(this).val();
                    var isNumber = /^[0-9]+$/.test(term);
                    var isAlpha = /^[a-zA-Z]+$/.test(term);

                    if (isNumber || isAlpha) {
                        $.ajax({
                            url: 'Controllers/FacturaCompraController.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'buscarMaquillajePorCodigo',
                                codigo: term
                            },
                            success: function(data) {
                                if (data.length > 0) {
                                    var item = data[0];
                                    console.log(item, 'item');
                                    var precioMayorista = item.Maqu_PrecioMayor;
                                    let preciov = item.Maqu_PrecioVenta;
                                    $(this).closest('tr').find('#precio_mayorista').text(precioMayorista);
                                    $(this).closest('tr').find('#precio_venta').text(preciov);
                                    $(this).closest('tr').find('#categoria').text('Maquillaje');
                                    $(this).closest('tr').find('input[name="precio_compra"]').val(item.Maqu_PrecioCompra);

                                } else {
                                    $(this).closest('tr').find('#precio_mayorista').text('0.00');
                                    $(this).closest('tr').find('#precio_venta').text('0.00');
                                    $(this).closest('tr').find('input[name="precio_compra"]').val('0.00');

                                }
                            }.bind(this),
                            error: function() {
                                $(this).closest('tr').find('#precio_mayorista').text('0.00');
                                $(this).closest('tr').find('#precio_venta').text('0.00');
                                $(this).closest('tr').find('input[name="precio_compra"]').val('0,00');

                            }.bind(this)
                        });
                    } else {
                        $.ajax({
                            url: 'Controllers/FacturaCompraController.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'buscarJoyaPorCodigo',
                                codigo: term
                            },
                            success: function(data) {
                                if (data.length > 0) {
                                    var item = data[0];
                                    console.log(item, 'item');
                                    var precioMayorista = item.Joya_PrecioMayor;
                                    let preciov = item.Joya_PrecioVenta;
                                    $(this).closest('tr').find('#precio_mayorista').text(precioMayorista);
                                    $(this).closest('tr').find('#precio_venta').text(preciov);
                                    $(this).closest('tr').find('#categoria').text('Joya');
                                    $(this).closest('tr').find('input[name="precio_compra"]').val(item.Joya_PrecioCompra);

                                } else {
                                    $(this).closest('tr').find('#precio_mayorista').text('0.00');
                                    $(this).closest('tr').find('#precio_venta').text('0.00');
                                    $(this).closest('tr').find('input[name="precio_compra"]').val('0.00');

                                }
                            }.bind(this),
                            error: function() {
                                $(this).closest('tr').find('#precio_mayorista').text('0.00');
                                $(this).closest('tr').find('#precio_venta').text('0.00');
                                $(this).closest('tr').find('input[name="precio_compra"]').val('0.00');

                            }.bind(this)
                        });
                    }
                });
            });



            $('#FacturaCompraForm').validate({
                rules: {
                    Proveedor: {
                        required: true
                    },
                    Sucursal: {
                        required: true
                    }

                },
                messages: {
                    Proveedor: {
                        required: "Por favor seleccione el Proveedor"
                    },
                    Sucursal: {
                        required: "Por favor seleccione la Sucursal"
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
            var table = $('#TablaFacturaCompra').DataTable({
                "ajax": {
                    "url": "Controllers/FacturaCompraController.php",
                    "type": "POST",
                    "data": function(d) {
                        d.action = 'listarFacturaCompras';
                    },
                    "dataSrc": function(json) {
                        console.log('Respuesta del servidor:', json);
                        if (json.error) {
                            console.error('Error recibido del servidor:', json.error);
                            return [];
                        }
                        return json.data;
                    },
                    "error": function(xhr, error, thrown) {
                        console.error('Error en la petición AJAX:', error, thrown);
                        console.log('Detalles de la respuesta AJAX:', xhr.responseText);
                    }
                },
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
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
                        "data": "Acciones"
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
                // $('#FacturaCompraForm')[0].reset();
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
                        selectProveedor.empty().append('<option selected="selected" value="">--Seleccione--</option>');
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
                        selectSucursal.empty().append('<option selected="selected" value="">--Seleccione--</option>');
                        sucursales.forEach(function(sucursal) {
                            selectSucursal.append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                        });
                    }
                });
            }

            cargarDatos();

            $('#TablaFacturaCompra tbody').on('click', '.abrir-editar', function() {
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
</body>

</html>