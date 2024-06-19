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
                    <div class="card-header">
                        <h3 class="text-center"><b>Factura Compra</b></h3>
                    </div>
                    <div class="card-body">
                        <div class="CrearOcultar">
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
                                            <input type="hidden" id="metodoPagoSeleccionado" name="metodoPagoSeleccionado" value="1" />
                                            <button type="button" class="btn btn-outline-info metodo-pago btn-selected-info" data-value="1">Efectivo</button>
                                            <button type="button" class="btn btn-outline-info metodo-pago deselected" data-value="4">Tarjeta de Crédito</button>
                                            <button type="button" class="btn btn-outline-info metodo-pago deselected" data-value="7">Pago en Línea</button>
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
                                                        <td><input type="number" class="form-control" name="cantidad" value="1" /></td>
                                                        <td><input type="text" class="form-control" id="precio_compra" name="precio_compra" value="0.00" oninput="validateNumber(this)" /></td>
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
                                    <div class="form-row d-flex justify-content-start">
                                        <div class="col-md-2">
                                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
                                            <input type="button" value="Confirmar" class="btn btn-primary" id="confirmarBtn" />

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




        $('#metodoPagoSeleccionado').val('1');

        var FaCE_Id = 0;

        function eliminarFila(button) {
            var row = button.closest('tr');
            var FaCD_Id = row.getAttribute('data-id');
            console.log(row, FaCD_Id);

            $.ajax({
                url: 'Services/FacturaCompraService.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'eliminarDetalleFactura',
                    FaCD_Id: FaCD_Id
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        row.remove();
                        console.log('Detalle eliminado correctamente.');
                    } else {
                        console.error('Error al eliminar el detalle:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición AJAX de eliminar detalle:', status, error);
                }
            });
        }

        $(document).ready(function() {

            $('#FacturaCompraForm').validate({
                rules: {
                    Proveedor: {
                        required: true
                    },

                    Sucursal: {
                        required: true
                    },
                },
                messages: {
                    Proveedor: {
                        required: "Por favor ingrese su DNI"
                    },

                    Sucursal: {
                        required: "Por favor elija su Sucursal"
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
            $('#AbrirModal').click(function() {
                $('.CrearOcultar').hide();
                $('.CrearMostrar').show();
                $('#FacturaCompraForm').trigger('reset');
                $('#FacturaCompraForm').validate().resetForm();
                sessionStorage.setItem('FaCE_Id', "0");
            });


            $('input[name="cantidad"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            function agregarNuevaFila() {
                var nuevaFila = `
        <tr data-id="NEW_ID">
            <td><p id="categoria"></p></td>
            <td><input type="text" class="form-control" name="producto" /></td>
            <td><input type="number" class="form-control" name="cantidad" value="1" /></td>
            <td><input type="text" class="form-control" name="precio_compra" value="0.00" oninput="validateNumber(this)" /></td>
            <td><p id="precio_venta">0.00</p></td>
            <td><p id="precio_mayorista">0.00</p></td>
            <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash-alt"></i></button></td>
        </tr>`;
                $('#detalleFactura').append(nuevaFila);
                aplicarAutocompletado();
            }

            $('.metodo-pago').click(function() {
                $('.metodo-pago').removeClass('btn-selected-info').addClass('deselected');
                $(this).removeClass('deselected').addClass('btn-selected-info');
                var valor = $(this).data('value');
                $('#metodoPagoSeleccionado').val(valor);
                console.log("Método de pago seleccionado: " + valor);
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

            function aplicarAutocompletado() {

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
                                    url: 'Services/FacturaCompraService.php',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: ajaxDataJoyas
                                }),
                                $.ajax({
                                    url: 'Services/FacturaCompraService.php',
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
                            }).catch(function(error) {
                                console.error('Error en la petición AJAX de autocompletado:', error);
                            });
                        } else if (/^[0-9]+/.test(term)) {
                            $(this).closest('tr').find('#categoria').text('Maquillaje');
                            $.ajax({
                                url: 'Services/FacturaCompraService.php',
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
                                },
                            });
                        }
                    },
                    minLength: 1,
                    select: function(event, ui) {
                        var selectedItem = ui.item.data;
                        let nombreProducto = selectedItem.Joya_Nombre || selectedItem.Maqu_Nombre;
                        var preciom = selectedItem.Mayor;
                        var preciov = selectedItem.Venta;
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
            }

            $('input[name="producto"]').on('blur', function() {
                var term = $(this).val();
                var isNumber = /^[0-9]+$/.test(term);
                var isAlpha = /^[a-zA-Z]+$/.test(term);

                if (isNumber || isAlpha) {
                    $.ajax({
                        url: 'Services/FacturaCompraService.php',
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

                                var row = $(this).closest('tr');
                                insertarActualizarFactura(row, item.Maqu_Nombre);

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
                        url: 'Services/FacturaCompraService.php',
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

                                var row = $(this).closest('tr');
                                insertarActualizarFactura(row, item.Joya_Nombre);

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

            $(document).on('blur', 'input[name="precio_compra"]', function() {
                if ($('#FacturaCompraForm').valid()) {
                    var row = $(this).closest('tr');
                    var producto = row.find('input[name="producto"]').val();


                    insertarActualizarFactura(row);
                    agregarNuevaFila();
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: 'El producto es requerido antes de agregar una nueva línea.',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                }
            });

            function cargarDatos() {
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
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
                    url: 'Services/FacturaCompraService.php',
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


            function insertarActualizarFactura(row) {
                var proveedor = $('#Proveedor').val();
                var sucursal = $('#Sucursal').val();
                var metodoPago = $('#metodoPagoSeleccionado').val();
                var producto = row.find('input[name="producto"]').val();
                var cantidad = row.find('input[name="cantidad"]').val();
                var precioCompra = row.find('input[name="precio_compra"]').val();
                var precioVenta = row.find('#precio_venta').text();
                var precioMayorista = row.find('#precio_mayorista').text();
                var categoria = row.find('#categoria').text() === 'Joya' ? 1 : 0;

                console.log('Datos a enviar para insertar/actualizar factura:', {
                    proveedor,
                    metodoPago,
                    sucursal,
                    FaCE_Id,
                    categoria,
                    producto,
                    cantidad,
                    precioCompra,
                    precioVenta,
                    precioMayorista,
                });

                if (FaCE_Id === 0) {
                    console.log('Entra a insertar encabezado');
                    $.ajax({
                        url: 'Services/FacturaCompraService.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'insertarFacturaEncabezado',
                            proveedor: proveedor,
                            metodoPago: metodoPago,
                            sucursal: sucursal,
                            usuarioCreacion: 1,
                            fechaCreacion: new Date().toISOString()
                        },
                        success: function(response) {
                            console.log('Respuesta de insertar encabezado:', response);
                            if (response.success) {
                                FaCE_Id = response.FaCE_Id;
                                insertarDetalle(FaCE_Id, producto, cantidad, precioCompra, precioVenta, precioMayorista, categoria);
                            } else {
                                console.error('Error al insertar la factura:', response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la petición AJAX de insertar encabezado:', status, error);
                        }
                    });
                } else {
                    insertarDetalle(FaCE_Id, producto, cantidad, precioCompra, precioVenta, precioMayorista, categoria);
                }
            }


            function insertarDetalle(faCE_Id, producto, cantidad, precioCompra, precioVenta, precioMayorista, categoria) {
                console.log('Datos a enviar para insertar detalle:', {
                    faCE_Id,
                    categoria,
                    producto,
                    cantidad,
                    precioCompra,
                    precioVenta,
                    precioMayorista,
                });
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'insertarDetalleFactura',
                        FaCE_Id: faCE_Id,
                        categoria: categoria,
                        producto: producto,
                        cantidad: cantidad,
                        precioCompra: precioCompra,
                        precioVenta: precioVenta,
                        precioMayorista: precioMayorista,
                    },
                    success: function(response) {
                        console.log('Respuesta de insertar detalle:', response);
                        if (response.success) {
                            obtenerDetalleId(faCE_Id, producto, categoria, response.success);
                        } else {
                            console.error('Error al insertar el detalle de la factura:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de insertar detalle:', status, error);
                    }
                });
            }

            $('#TablaFacturaCompra tbody').on('click', '.abrir-editar', function() {
                var data = table.row($(this).parents('tr')).data();
                sessionStorage.setItem('FaCE_Id', data.FaCE_Id);

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    method: 'POST',
                    data: {
                        action: 'buscar',
                        FaCE_Id: data.FaCE_Id
                    },
                    success: function(response) {
                        console.log('editar encabezado', response);
                        var data = JSON.parse(response).data[0];
                        $('#Proveedor').val(data.Prov_Id).trigger('change');
                        $('#Sucursal').val(data.sucu_Id).trigger('change');
                        $('#metodoPagoSeleccionado').val(data.Mepa_Id);
                        $('#categoria').val(data.Categoria);

                        $('.CrearOcultar').hide();
                        $('.CrearMostrar').show();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    method: 'POST',
                    data: {
                        action: 'buscardetalle',
                        FaCE_Id: data.FaCE_Id
                    },
                    success: function(response) {
                        console.log('editar detalle', response);
                        var data = JSON.parse(response).data[0];
                        $(this).closest('tr').find('#producto').text(data.Prod_Id);
                        $(this).closest('tr').find('#cantidad').text(data.Cantidad);
                        $(this).closest('tr').find('#precio_compra').text(data.Precio_Venta);
                        $(this).closest('tr').find('#precio_venta').text(data.PrecioVenta);
                        $(this).closest('tr').find('#precio_mayorista').text(data.precioMayorista);

                        $('.CrearOcultar').hide();
                        $('.CrearMostrar').show();
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            function obtenerDetalleId(faCE_Id, producto, categoria) {
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'obtenerFacturaCompraDetalleId',
                        FaCE_Id: faCE_Id,
                        producto: producto,
                        FaCD_Dif: categoria
                    },
                    success: function(response) {
                        console.log('Respuesta de obtener detalle ID:', response);
                        if (response.success) {
                            var row = $('tr[data-id="NEW_ID"]'); // Selecciona la fila que acabamos de insertar
                            row.attr('data-id', response.FaCD_Id); // Actualiza el atributo data-id con el ID real
                        } else {
                            console.error('Error al obtener el ID del detalle:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de obtener detalle ID:', status, error);
                    }
                });
            }


            aplicarAutocompletado();



            sessionStorage.setItem('FaCE_Id', "0");
            var table = $('#TablaFacturaCompra').DataTable({
                "ajax": {
                    "url": "Services/FacturaCompraService.php",
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



            $('#CerrarModal').click(function() {
                $('.CrearOcultar').show();
                $('.CrearMostrar').hide();
                $('#FacturaCompraForm')[0].reset();
            });

            cargarDatos();

        });
    </script>
</body>

</html>