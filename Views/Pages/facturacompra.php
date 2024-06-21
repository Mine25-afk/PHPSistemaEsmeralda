<style>
    .form-row {
        justify-content: center;
        margin: 0px 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    /* .btn-outline-success {
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
    } */

    /* .btn-selected-success {
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
    } */

    .input-group-append .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .disabled-button {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

</head>

<body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">


                    <div class="card-body">
                        <div class="CrearOcultar" style="position:relative; top:-30px">
                            <h2 class="text-center" style="font-size: 90px !important">Factura Compra</h2>
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
                            <h2 class="text-center" style="font-size: 90px !important">Factura Compra</h2>
                            <form id="FacturaCompraForm" style="width: 100%">
                                <div class="form-row" style="justify-content: center; margin: 0px 10px">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Proveedor</label>
                                            <select id="Proveedor" name="Proveedor" class="form-control" style="width: 100%;">
                                                <option value="">--Seleccione--</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sucursal</label>
                                            <select id="Sucursal" name="Sucursal" class="form-control" style="width: 100%;">
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
                                            <button type="button" class="btn btn-secondary metodo-pago btn-selected-info" data-value="1"><i class="fas fa-dollar-sign"></i> Efectivo</button>
                                            <button type="button" class="btn btn-secondary metodo-pago deselected" data-value="4"><i class="fas fa-credit-card"></i> Tarjeta de Crédito</button>
                                            <button type="button" class="btn btn-secondary metodo-pago deselected" data-value="7"><i class="fas fa-donate"></i> Pago en Línea</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-row d-flex justify-content-start">
                                        <div class="col-md-12">
                                            <table class="table  table-striped table-bordered">
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
                                                        <td>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="producto" />
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-outline-secondary" type="button" id="btnNuevoProducto"><i class="fas fa-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </td>
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
                                                <tfoot>

                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <div class="card-body">
                                    <div class="form-row d-flex justify-content-end">
                                        <div class="col-auto">

                                            <input type="button" value="Confirmar" class="btn btn-primary" id="btnConfirmar" />
                                        </div>
                                        <div class="col-auto">
                                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Cancelar</a>
                                        </div>

                                    </div>
                                </div>
                        </div>


                    </div>
                </div>
                </form>
            </div>

            <div class="collapse" id="collapseNuevoProducto">
                <h2 class="text-center" style="font-size: 90px !important">Agregar Producto</h2>
                <form id="NuevoProductoForm" style="width: 100%">
                    <div class="form-row" id="productTypeSelection">

                        <div class="col-sm-12">
                            <div class="d-flex align-items-center">
                                <div class="custom-control custom-radio mr-3">
                                    <input class="custom-control-input" type="radio" id="radioMaquillaje" name="productType" value="maquillaje" checked>
                                    <label for="radioMaquillaje" class="custom-control-label">Maquillaje</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="radioJoya" name="productType" value="joya">
                                    <label for="radioJoya" class="custom-control-label">Joya</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Nombre del Producto</label>
                            <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" required />
                        </div>
                        <div class="col-md-6">
                            <label>Precio Compra</label>
                            <input type="text" class="form-control" id="precioCompraProducto" name="precioCompraProducto" required />
                        </div>
                        <div class="col-md-6">
                            <label>Precio Venta</label>
                            <input type="text" class="form-control" id="precioVentaProducto" name="precioVentaProducto" required />
                        </div>
                        <div class="col-md-6">
                            <label>Precio Mayorista</label>
                            <input type="text" class="form-control" id="precioMayoristaProducto" name="precioMayoristaProducto" required />
                            <br>
                        </div>
                        <div class="col-md-6" id="marcaField">
                            <label>Marca</label>
                            <select name="Marc_Id" class="form-control" id="Marc_Id"></select>
                        </div>
                        <div class="col-md-6" id="materialField" style="display:none;">
                            <label>Material</label>
                            <select name="Mate_Id" class="form-control" id="Mate_Id" required></select>
                        </div>
                        <div class="col-md-6" id="categoriaField" style="display:none;">
                            <label>Categoría</label>
                            <select name="Cate_Id" class="form-control" id="Cate_Id" required></select>
                        </div>
                
                            <div class="custom-file col-md-6">
                                <label>Imagen</label>
                                <input type="file" name="Imagen" class="custom-file-input" id="Imagen" required />
                                <label class="custom-file-label"></label>
                            </div>
                  

                        <div class="col-md-4"></div>
                        <br>
                        <div class="col-md-6">
                            <br>
                            <label>Imagen Actual</label>
                            <div id="imagenActualContainer">
                                <img id="imagenActual" src="#" alt="Imagen Actual" style="max-width: 100%;" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="card-body">
                        <div class="form-row d-flex justify-content-end">
                            <div class="col-auto">


                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-secondary" style="color:white" id="btnVolverFacturaCompra">Cancelar</button>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        function validateNumber(input) {
            input.value = input.value.replace(/[^0-9.,]/g, '');
        }

        $(document).on('click', '#btnNuevoProducto', function() {
            $('#collapseNuevoProducto').collapse('show');
            $('.CrearOcultar').hide();
            $('.CrearMostrar').hide();

            sessionStorage.setItem('actualFaceId', FaCE_Id);

            if ($('#radioJoya').is(':checked')) {
                cargarMaterialesCategorias();
            } else {
                cargarMarcas();
            }
        });


        $(document).on('click', '#btnVolverFacturaCompra', function() {
            $('#collapseNuevoProducto').collapse('hide');
            $('.CrearOcultar').show();
            $('.CrearMostrar').show();
        });
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
                        iziToast.success({
                            title: 'Exito',
                            message: 'Detalle eliminado correctamente.',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Error al eliminar.',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    }
                },
                error: function(xhr, status, error) {}
            });
        }

        function deshabilitarCampos() {
            $('#Proveedor').prop('disabled', true);
            $('#Sucursal').prop('disabled', true);
            $('.metodo-pago').addClass('disabled-button');
        }

        function habilitarCampos() {
            $('#Proveedor').prop('disabled', false);
            $('#Sucursal').prop('disabled', false);
            $('.metodo-pago').removeClass('disabled-button');
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
                    Producto: {
                        required: true
                    }
                },
                messages: {
                    Proveedor: {
                        required: "Por favor ingrese su DNI"
                    },

                    Sucursal: {
                        required: "Por favor elija su Sucursal"
                    },
                    Producto: {
                        required: "Por favor inserte el producto"
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
                FaCE_Id = 0;
                $('#detalleFactura').empty();
                cargarImagenActual(null);

                habilitarCampos();

                $('#Proveedor').val('').trigger('change');
                $('#Sucursal').val('').trigger('change');

                $('#metodoPagoSeleccionado').val('1');
                $('.metodo-pago').removeClass('btn-selected-info').addClass('deselected');
                $('.metodo-pago[data-value="1"]').removeClass('deselected').addClass('btn-selected-info');

                agregarNuevaFila();
            });

            function cargarImagenActual(imagen) {
                var imagenActual = $('#imagenActual');
                if (imagen) {
                    var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/joyas/' + encodeURIComponent(imagen);
                    imagenActual
                        .attr('src', imageUrl)
                        .attr('style', 'max-width: 100%; max-height: 200px;')
                        .show();
                } else {
                    imagenActual
                        .attr('src', '#')
                        .hide();
                }
            }

            $('input[name="cantidad"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            function agregarNuevaFila() {
                var nuevaFila = `
<tr data-id="NUEVOID">
    <td><p id="categoria"></p></td>
    <td>
        <div class="input-group">
            <input type="text" class="form-control" name="producto" />
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" id="btnNuevoProducto"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </td>
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
            });

            $('.metodo-pago').click(function() {
                $('.metodo-pago').removeClass('btn-selected-success btn-selected-info btn-selected-danger').addClass('deselected');
                $(this).removeClass('deselected');

                $(this).addClass('btn-selected-info');
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
                        var seleccionadoitem = ui.item.data;
                        let nombreProducto = seleccionadoitem.Joya_Nombre || seleccionadoitem.Maqu_Nombre;
                        var preciom = seleccionadoitem.Mayor;
                        var preciov = seleccionadoitem.Venta;
                        $(this).closest('tr').find('#precio_mayorista').text(preciom);
                        $(this).closest('tr').find('#precio_venta').text(preciov);
                        $(this).closest('tr').find('input[name="precio_compra"]').val(seleccionadoitem.Joya_PrecioCompra || seleccionadoitem.Maqu_PrecioCompra);
                        if (seleccionadoitem.Joya_Codigo) {
                            $(this).closest('tr').find('#categoria').text('Joya');
                        } else {
                            $(this).closest('tr').find('#categoria').text('Maquillaje');
                        }
                    }

                });
            }



            $(document).on('blur', 'input[name="producto"]', function() {
                var term = $(this).val();
                var row = $(this).closest('tr');
                var numeroo = /^[0-9]+$/.test(term);
                var alfanumerico = /^[a-zA-Z]+$/.test(term);
                console.log('Term:', term);

                if (numeroo || alfanumerico) {
                    console.log('entra al numeroalfa');
                    var ajaxData = {
                        action: numeroo ? 'buscarJoyaPorCodigo' : 'buscarMaquillajePorCodigo',
                        codigo: term
                    };

                    $.ajax({
                        url: 'Services/FacturaCompraService.php',
                        type: 'POST',
                        dataType: 'json',
                        data: ajaxData,
                        success: function(data) {
                            if (data.length > 0) {
                                var item = data[0];
                                console.log('Item:', item);
                                var precioCompra = item.Joya_PrecioCompra || item.Maqu_PrecioCompra || 0;
                                var precioMayorista = item.Joya_PrecioMayor || item.Maqu_PrecioMayor;
                                var precioVenta = item.Joya_PrecioVenta || item.Maqu_PrecioVenta;

                                row.find('#precio_mayorista').text(precioMayorista);
                                row.find('#precio_venta').text(precioVenta);
                                row.find('input[name="precio_compra"]').val(precioCompra);

                                if (item.Joya_Codigo) {
                                    row.find('#categoria').text('Joya');
                                } else {
                                    row.find('#categoria').text('Maquillaje');
                                }

                                // Inserta o actualiza la factura con la información obtenida
                                // insertarActualizarFactura(row, item.Nombre);
                            } else {
                                row.find('#precio_mayorista').text('0.00');
                                row.find('#precio_venta').text('0.00');
                                row.find('input[name="precio_compra"]').val('0.00');
                            }
                        },
                        error: function() {
                            row.find('#precio_mayorista').text('0.00');
                            row.find('#precio_venta').text('0.00');
                            row.find('input[name="precio_compra"]').val('0.00');
                        }
                    });
                } else {
                    console.log('entra a solo joya');
                    var ajaxData = {
                        action: 'buscarJoyaPorCodigo',
                        codigo: term
                    };

                    $.ajax({
                        url: 'Services/FacturaCompraService.php',
                        type: 'POST',
                        dataType: 'json',
                        data: ajaxData,
                        success: function(data) {
                            if (data.length > 0) {
                                var item = data[0];
                                console.log('Item:', item);
                                var precioCompra = item.Joya_PrecioCompra;
                                var precioMayorista = item.Joya_PrecioMayor;
                                var precioVenta = item.Joya_PrecioVenta;

                                row.find('#precio_mayorista').text(precioMayorista);
                                row.find('#precio_venta').text(precioVenta);
                                row.find('input[name="precio_compra"]').val(precioCompra);

                                row.find('#categoria').text('Joya');

                                // Inserta o actualiza la factura con la información obtenida
                                // insertarActualizarFactura(row, item.Nombre);
                            } else {
                                row.find('#precio_mayorista').text('0.00');
                                row.find('#precio_venta').text('0.00');
                                row.find('input[name="precio_compra"]').val('0.00');
                            }
                        },
                        error: function() {
                            row.find('#precio_mayorista').text('0.00');
                            row.find('#precio_venta').text('0.00');
                            row.find('input[name="precio_compra"]').val('0.00');
                        }
                    });
                }
            });

            $(document).on('blur', 'input[name="precio_compra"]', function() {
                var row = $(this).closest('tr');
                var producto = row.find('input[name="producto"]').val();
                if ($('#FacturaCompraForm').valid() && producto.trim() !== '') {
                    insertarActualizarFactura(row);
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
                        var provseleccionado = $('#Proveedor');
                        provseleccionado.empty().append('<option selected="selected" value="">--Seleccione--</option>');
                        proveedores.forEach(function(proveedor) {
                            provseleccionado.append('<option value="' + proveedor.Prov_Id + '">' + proveedor.Prov_Proveedor + '</option>');
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
                        var sucuseleccionada = $('#Sucursal');
                        sucuseleccionada.empty().append('<option selected="selected" value="">--Seleccione--</option>');
                        sucursales.forEach(function(sucursal) {
                            sucuseleccionada.append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                        });
                    }
                });
            }

            function cargarMaterialesCategorias() {
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    data: {
                        action: 'listarMateriales'
                    },
                    success: function(response) {
                        const materiales = JSON.parse(response).data;
                        $('#Mate_Id').empty().append('<option value="">--Seleccione--</option>');
                        materiales.forEach(material => {
                            $('#Mate_Id').append('<option value="' + material.Mate_Id + '">' + material.Mate_Material + '</option>');
                        });
                    }
                });
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    data: {
                        action: 'listarCategorias'
                    },
                    success: function(response) {
                        const categorias = JSON.parse(response).data;
                        $('#Cate_Id').empty().append('<option value="">--Seleccione--</option>');
                        categorias.forEach(categoria => {
                            $('#Cate_Id').append('<option value="' + categoria.Cate_Id + '">' + categoria.Cate_Categoria + '</option>');
                        });
                    }
                });
            }

            function cargarMarcas() {
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    data: {
                        action: 'listarMarcas'
                    },
                    success: function(response) {
                        const marcas = JSON.parse(response).data;
                        $('#Marc_Id').empty().append('<option value="">--Seleccione--</option>');
                        marcas.forEach(marca => {
                            $('#Marc_Id').append('<option value="' + marca.Marc_Id + '">' + marca.Marc_Marca + '</option>');
                        });
                    }
                });
            }

            $('#radioJoya').change(function() {
                if ($(this).is(':checked')) {
                    $('#materialField').show();
                    $('#categoriaField').show();
                    $('#marcaField').hide();
                    cargarMaterialesCategorias();
                }
            });

            $('#radioMaquillaje').change(function() {
                if ($(this).is(':checked')) {
                    $('#materialField').hide();
                    $('#categoriaField').hide();
                    $('#marcaField').show();
                    cargarMarcas();
                }
            });

            cargarMarcas();

            $('#Imagen').change(function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagenActual')
                            .attr('src', e.target.result)
                            .attr('style', 'max-width: 100%; max-height: 200px;')
                            .show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });

            $('#NuevoProductoForm').on('submit', function(event) {
                event.preventDefault();

                const formData = new FormData(this);

                var tipoProducto = $('input[name="productType"]:checked').val();
                formData.append('tipo', tipoProducto);

                var codigoProducto;
                if (tipoProducto === 'joya') {
                    var materialSeleccionado = $('#Mate_Id option:selected').text();
                    var codigoMaterial = materialSeleccionado.substring(0, 2).toUpperCase();
                    var codigoAleatorio = Math.floor(1000 + Math.random() * 9000);
                    codigoProducto = codigoMaterial + codigoAleatorio;
                } else if (tipoProducto === 'maquillaje') {
                    var categoriaSeleccionada = $('#Marc_Id option:selected').text();
                    var codigoCategoria = categoriaSeleccionada.substring(0, 2).toUpperCase();
                    var codigoAleatorio = Math.floor(1000 + Math.random() * 9000);
                    codigoProducto = codigoCategoria + codigoAleatorio;
                }
                formData.append('productoCodigo', codigoProducto);

                formData.append('action', 'insertarProducto');
                formData.append('nombre', $('#nombreProducto').val());
                formData.append('precio_compra', $('#precioCompraProducto').val());
                formData.append('precio_venta', $('#precioVentaProducto').val());
                formData.append('precio_mayorista', $('#precioMayoristaProducto').val());
                formData.append('imagen', $('#Imagen')[0].files[0]);
                formData.append('stock', 1);
                formData.append('usuario_creacion', 1);
                formData.append('fecha_creacion', new Date().toISOString().slice(0, 19).replace('T', ' '));

                if (tipoProducto === 'joya') {
                    formData.append('material', $('#Mate_Id').val());
                    formData.append('categoria', $('#Cate_Id').val());
                } else if (tipoProducto === 'maquillaje') {
                    formData.append('marca', $('#Marc_Id').val());
                }

                var proveedorSeleccionado = $('#Proveedor').val();
                formData.append('proveedor', proveedorSeleccionado);

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        try {
                            response = JSON.parse(response);
                            if (response.result == 1) {
                                iziToast.success({
                                    title: 'Éxito',
                                    message: 'Producto insertado correctamente',
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX'
                                });

                                var actualFaceId = sessionStorage.getItem('actualFaceId');
                                if (actualFaceId) {
                                    FaCE_Id = actualFaceId;

                                    var nuevoProductoNombre = $('#nombreProducto').val();
                                    var nuevoProductoPrecioCompra = $('#precioCompraProducto').val();
                                    var nuevoProductoPrecioVenta = $('#precioVentaProducto').val();
                                    var nuevoProductoPrecioMayorista = $('#precioMayoristaProducto').val();

                                    sessionStorage.setItem('nuevoProductoNombre', nuevoProductoNombre);
                                    sessionStorage.setItem('nuevoProductoPrecioCompra', nuevoProductoPrecioCompra);
                                    sessionStorage.setItem('nuevoProductoPrecioVenta', nuevoProductoPrecioVenta);
                                    sessionStorage.setItem('nuevoProductoPrecioMayorista', nuevoProductoPrecioMayorista);

                                    editarFactura(FaCE_Id);
                                }

                                $('#collapseNuevoProducto').collapse('hide');
                                $('.CrearOcultar').show();
                                $('.CrearMostrar').hide();
                                $('#NuevoProductoForm')[0].reset();
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Error al insertar el producto: ' + (response.error ? response.error : ''),
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX'
                                });
                            }
                        } catch (e) {
                            iziToast.error({
                                title: 'Error',
                                message: 'Error al insertar el producto. La respuesta del servidor no es válida.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        iziToast.error({
                            title: 'Error',
                            message: 'Error en la comunicación con el servidor',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX'
                        });
                    }
                });
            });

            function editarFactura(faCE_Id) {
                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'buscar',
                        FaCE_Id: faCE_Id
                    },
                    success: function(response) {
                        console.log('editar encabezado', response);
                        var factura = response.data[0];

                        $.ajax({
                            url: 'Services/FacturaCompraService.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'buscardetalle',
                                FaCE_Id: faCE_Id
                            },
                            success: function(responseDetalle) {
                                console.log('editar detalle', responseDetalle);
                                var detalles = responseDetalle.length > 0 ? responseDetalle : [];
                                llenarCamposFactura(factura, detalles);
                                var nuevoProductoNombre = sessionStorage.getItem('nuevoProductoNombre');
                                var nuevoProductoPrecioCompra = sessionStorage.getItem('nuevoProductoPrecioCompra');
                                var nuevoProductoPrecioVenta = sessionStorage.getItem('nuevoProductoPrecioVenta');
                                var nuevoProductoPrecioMayorista = sessionStorage.getItem('nuevoProductoPrecioMayorista');

                                if (nuevoProductoNombre) {
                                    $('input[name="producto"]:last').val(nuevoProductoNombre);
                                    $('input[name="precio_compra"]:last').val(nuevoProductoPrecioCompra);
                                    $('#precio_venta:last').text(nuevoProductoPrecioVenta);
                                    $('#precio_mayorista:last').text(nuevoProductoPrecioMayorista);

                                    sessionStorage.removeItem('nuevoProductoNombre');
                                    sessionStorage.removeItem('nuevoProductoPrecioCompra');
                                    sessionStorage.removeItem('nuevoProductoPrecioVenta');
                                    sessionStorage.removeItem('nuevoProductoPrecioMayorista');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la petición AJAX de obtener detalles de factura:', status, error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de obtener datos de factura:', status, error);
                    }
                });
            }


            function insertarActualizarFactura(row) {
                if ($('#FacturaCompraForm').valid()) {
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

                    if (FaCE_Id > 0) {
                        insertarDetalle(FaCE_Id, producto, cantidad, precioCompra, precioVenta, precioMayorista, categoria);
                    } else {
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
                                    deshabilitarCampos();

                                } else {
                                    console.error('Error al insertar la factura:', response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la petición AJAX de insertar encabezado:', status, error);
                            }
                        });
                    }
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
                        if (response.success) {
                            var row = $('tr[data-id="NUEVOID"]');
                            var cantidad = row.find('input[name="cantidad"]').val();
                            var precioCompra = row.find('input[name="precio_compra"]').val();
                            row.attr('data-id', response.FaCD_Id);
                            row.find('input[name="producto"]').replaceWith('<p>' + producto + '</p>');
                            row.find('input[name="cantidad"]').replaceWith('<p>' + cantidad + '</p>');
                            row.find('input[name="precio_compra"]').replaceWith('<p>' + precioCompra + '</p>');

                            row.find('#btnNuevoProducto').remove();

                            agregarNuevaFila();
                            iziToast.success({
                                title: 'Exito',
                                message: 'Producto agregado con exito.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        } else {
                            console.error('no deja', response.message);
                            iziToast.error({
                                title: 'Error',
                                message: 'Ingrese un producto existente.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de obtener detalle ID:', status, error);
                    }
                });
            }

            $("#btnConfirmar").click(function() {
                if (sessionStorage.getItem("Mepa_Metodo") == "7") {
                    $("#ModalTransferencias").modal("show")

                } else {

                    $.ajax({
                        url: 'Services/FacturaCompraService.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            action: 'finalizarFacturaCompra',
                            FaCE_Id: FaCE_Id,
                            fechaFinal: new Date().toISOString()
                        },
                        success: function(response) {
                            if (response.success) {
                                iziToast.success({
                                    title: 'Exito',
                                    message: 'Factura finalizada correctamente.',
                                    position: 'topRight',
                                    transitionIn: 'flipInX',
                                    transitionOut: 'flipOutX'
                                });
                                table.ajax.reload();
                            } else {
                                console.error('Error al finalizar la factura:', response.message);
                            }

                        },
                        error: function() {

                        }
                    });
                }

            })

            $('#TablaFacturaCompra tbody').on('click', '.abrir-finalizar', function() {
                var row = $(this).closest('tr');
                var data = table.row(row).data();
                console.log(data, 'data');
                var FaCE_Id = data.FaCE_Id;

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'finalizarFacturaCompra',
                        FaCE_Id: FaCE_Id,
                        fechaFinal: new Date().toISOString()
                    },
                    success: function(response) {
                        if (response.success) {
                            iziToast.success({
                                title: 'Exito',
                                message: 'Factura finalizada correctamente.',
                                position: 'topRight',
                                transitionIn: 'flipInX',
                                transitionOut: 'flipOutX'
                            });
                            table.ajax.reload();
                        } else {
                            console.error('Error al finalizar la factura:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX para finalizar factura:', status, error);
                    }
                });
            });

            $('#TablaFacturaCompra tbody').on('click', '.abrir-imprimir', function() {
                var row = $(this).closest('tr');
                var data = table.row(row).data();
                var FaCE_Id = data.FaCE_Id;
                console.log(data);

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'buscar',
                        FaCE_Id: FaCE_Id
                    },
                    success: function(response) {
                        var factura = response.data[0];
                        $.ajax({
                            url: 'Services/FacturaCompraService.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'buscardetalle',
                                FaCE_Id: FaCE_Id
                            },
                            success: function(responseDetalle) {
                                var detalles = responseDetalle.length > 0 ? responseDetalle : [];
                                console.log('detalles', detalles);
                                generarPDF(factura, detalles);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la petición AJAX de obtener detalles de factura:', status, error);
                                generarPDF(factura, []);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de obtener datos de factura:', status, error);
                    }
                });
            });

            function generarPDF(factura, detalles) {
                var doc = new jsPDF({
                    orientation: 'portrait',
                    unit: 'px',
                    format: 'letter'
                });

                var pageNumber = 1;
                var img = new Image();
                img.src = 'Views/Logo.png';

                doc.addImage(img, 'PNG', 10, 10, 200, 50);

                doc.setFontSize(10);
                doc.setFont(undefined, 'bold');
                doc.text('Esmeraldas HN', 280, 30);

                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                doc.text('Dirección :', 280, 40);
                doc.text("Tegucigalpa: Los dolores, calle buenos aires", 280, 50);

                doc.setFontSize(16);
                doc.setFont(undefined, 'bold');
                doc.text("PEDIDO", 32, 100);

                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                doc.text("Proveedor: " + (factura.nombreProveedor || ''), 32, 110);
                doc.text("Teléfono: " + (factura.Prov_Telefono || ''), 32, 120);
                doc.text("Departamento: " + (factura.Depa_Departamento || ''), 32, 130);

                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                doc.text("Fecha Pedido: " + (factura.FaCE_FechaCreacion || ''), 280, 110);
                doc.text("Metodo Pago: " + (factura.Mepa_Metodo || ''), 280, 120);
                doc.text("Sucursal: " + (factura.sucu_Nombre || ''), 280, 130);

                const footer = () => {
                    doc.setFontSize(10);
                    doc.setFont(undefined, 'normal');
                    doc.text(String(pageNumber), 444, 580, {
                        align: 'right'
                    });
                };

                doc.autoTable({
                    head: [
                        ['No.', 'Codigo', 'Producto', 'Cantidad', 'Categoría', 'Precio Compra', 'Precio Venta', 'Precio Mayorista', 'Subtotal']
                    ],
                    body: detalles.map(detalle => [
                        factura.faCE_Id,
                        detalle.Prod_Id || 'N/A',
                        detalle.Producto || 'N/A',
                        detalle.Cantidad ? detalle.Cantidad.toString() : '0',
                        detalle.Categoria || 'N/A',
                        detalle.PrecioCompra ? detalle.Precio_Venta : '0.00',
                        detalle.PrecioVenta ? detalle.PrecioVenta : '0.00',
                        detalle.PrecioMayorista ? detalle.PrecioMayorista : '0.00',
                        (detalle.Cantidad * detalle.Precio_Venta).toFixed(2) || '0.00'
                    ]),
                    startY: pageNumber === 1 ? 180 : 170,
                    styles: {
                        fontSize: 10,
                    },
                    headStyles: {
                        fillColor: [0, 0, 0],
                        textColor: [255, 255, 255],
                        halign: 'center',
                        valign: 'middle',
                        fontStyle: 'bold',
                    },
                    columnStyles: {
                        0: {
                            halign: 'center'
                        },
                        1: {
                            halign: 'center'
                        },
                        2: {
                            halign: 'center'
                        },
                        3: {
                            halign: 'center'
                        },
                        4: {
                            halign: 'center'
                        },
                        5: {
                            halign: 'center'
                        },
                        6: {
                            halign: 'center'
                        },
                        7: {
                            halign: 'center'
                        }
                    },
                    theme: 'grid',
                    didDrawPage: (data) => {
                        footer();
                        pageNumber++;
                    }
                });

                doc.save(`FacturaCompra - ${factura.faCE_Id}.pdf`);
            }




            function llenarCamposFactura(factura, detalles) {
                $('#Proveedor').val(factura.Prov_Id).trigger('change');
                $('#Sucursal').val(factura.sucu_Id).trigger('change');
                $('#metodoPagoSeleccionado').val(factura.Mepa_Id);
                $('.metodo-pago').removeClass('btn-selected-info').addClass('deselected');
                $(`.metodo-pago[data-value="${factura.Mepa_Id}"]`).removeClass('deselected').addClass('btn-selected-info');

                $('#detalleFactura').empty();

                detalles.forEach(detalle => {
                    var nuevaFila = `
            <tr data-id="${detalle.faCD_Id}">
                <td><p>${detalle.Categoria}</p></td>
                <td><p>${detalle.Producto}</p></td>
                <td><p>${detalle.Cantidad}</p></td>
                <td><p>${detalle.Precio_Venta}</p></td>
                <td><p>${detalle.PrecioVenta}</p></td>
                <td><p>${detalle.PrecioMayorista}</p></td>
                <td><button type="button" class="btn btn-danger" onclick="eliminarFila(this)"><i class="fas fa-trash-alt"></i></button></td>
            </tr>`;
                    $('#detalleFactura').append(nuevaFila);
                });
                agregarNuevaFila();

                $('.CrearOcultar').hide();
                $('.CrearMostrar').show();
            }

            $('#TablaFacturaCompra tbody').on('click', '.abrir-editar', function() {
                var row = $(this).closest('tr');
                var data = table.row(row).data();
                FaCE_Id = data.FaCE_Id;

                $.ajax({
                    url: 'Services/FacturaCompraService.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'buscar',
                        FaCE_Id: FaCE_Id
                    },
                    success: function(response) {
                        var factura = response.data[0];

                        $.ajax({
                            url: 'Services/FacturaCompraService.php',
                            method: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'buscardetalle',
                                FaCE_Id: FaCE_Id
                            },
                            success: function(responseDetalle) {
                                console.log('editar detalle', responseDetalle);
                                var detalles = responseDetalle.length > 0 ? responseDetalle : [];
                                llenarCamposFactura(factura, detalles);
                                deshabilitarCampos();

                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la petición AJAX de obtener detalles de factura:', status, error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la petición AJAX de obtener datos de factura:', status, error);
                    }
                });
            });


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
                        if (json.error) {
                            console.error('Erro:', json.error);
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
                $('#FacturaCompraForm').validate().resetForm();

                $('#Proveedor').val('').trigger('change');
                $('#Sucursal').val('').trigger('change');
            });

            cargarDatos();

        });
    </script>