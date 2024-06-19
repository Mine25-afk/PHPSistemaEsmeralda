<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferencias</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow-y: scroll; 
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
            max-height: 500px;
            overflow-y: auto; 
        }

        .grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .field {
            flex: 1 1 calc(50% - 20px);
        }

        .styled-input-group {
            display: flex;
            align-items: center;
        }

        .styled-addon {
            background-color: #e0e0e0;
            padding: 10px;
        }

        .autocomplete-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #f4f4f4;
        }

        .data-table tfoot td {
            background-color: #f9f9f9;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            width: 100%;
        }
    </style>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="text-center">Transferencias</h1>
            </div>
            <div class="card-body">
                <form id="FacturaForm">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Sucursal Envío</label>
                            <select name="SucursalEnvio" class="form-control" id="SucursalEnvio" required></select>
                            <small id="SucursalEnvio_error" style="color: red; display: none;">Seleccione una opcion.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Sucursal Recibido</label>
                            <select name="SucursalRecibido" class="form-control" id="SucursalRecibido" required></select>
                            <small id="SucursalRecibido_error" style="color: red; display: none;">Seleccione una opcion.</small>
                        </div>
                    </div>
                    <table id="ProductoDetalle" class="data-table">
                        <thead>
                            <tr>
                                <th>Categoría</th>
                                <th>Código</th>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Precio Mayorista</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                
                                </td>
                                <td>
                                    <input type="text" id="Prod_Id" name="Prod_Id" autocomplete="off" onblur="buscarProductoPorCodigo()">
                                    <small id="Prod_IdError" style="color: red; display: none;">Código vacío.</small>
                                </td>
                                <td>
                                    <input type="text" id="Prod_Nombre_" name="Prod_Nombre_" autocomplete="off" oninput="debounceBuscarProductoPorNombre()">
                                    <small id="Prod_Nombre_Error" style="color: red; display: none;">Codigo vacío.</small>
                                </td>
                                <td>
                                    <input type="number" id="Prsx_Stock_" name="Prsx_Stock_" required min="1">
                                    <br>
                                    <small id="Prsx_Stock_Error" style="color: red; display: none;">Cantidad vacía o debe ser mayor que 0.</small>
                                </td>
                               
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
                <br>
                <br>
            </div>
          
        </div>
        
    </div>
    
</body>

</html>



    <script>
        $(document).ready(function() {
            cargarSucursales();

            $('#SucursalRecibido').change(function() {
                var sucursalId = $(this).val();
                if (sucursalId !== '') {
                    obtenerProductosPorCodigoDropdownlist(sucursalId);
                } else {
                    limpiarTablaProductos();
                }
            });
        });

            //Tab
        $('#Prsx_Stock_').keydown(function(event) {
        if (event.keyCode === 9) { 
            event.preventDefault(); 
            submitForm(); 
        }
    });
    
        function cargarSucursales() {
            $.ajax({
                url: 'Services/TransferenciasService.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'listarSucursales'
                },
                success: function(response) {
                    if (response && response.length > 0) {
                        $('#SucursalEnvio').empty().append('<option value="">Seleccione una opción</option>');
                        $('#SucursalRecibido').empty().append('<option value="">Seleccione una opción</option>');

                        response.forEach(function(sucursal) {
                            $('#SucursalEnvio').append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                            $('#SucursalRecibido').append('<option value="' + sucursal.Sucu_Id + '">' + sucursal.Sucu_Nombre + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al cargar las sucursales:', error);
                }
            });
        }

        function obtenerProductosPorCodigoDropdownlist(sucursalId) {
            $.ajax({
                url: 'Services/TransferenciasService.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'obtenerProductosPorCodigoDropdownlist',
                    Sucu_Id: sucursalId
                },
                success: function(response) {
                    if (response && response.data) {
                        llenarTablaProductos(response.data);
                    } else {
                        limpiarTablaProductos();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener productos por sucursal:', error);
                    limpiarTablaProductos();
                }
            });
        }

        function llenarTablaProductos(data) {
            var tbody = $('#ProductoDetalle tbody');
            tbody.empty();

            data.forEach(function(producto) {
                var precioVenta = producto.PrecioVenta !== null ? producto.PrecioVenta : 0;
                var precioMayorista = producto.PrecioMayorista !== null ? producto.PrecioMayorista : 0;
                var PrecioCompra = producto.PrecioCompra !== null ? producto.PrecioCompra : 0;

                var row = '<tr>' +
                    '<td>' + producto.Categoria + '</td>' +
                    '<td>' + producto.Codigo + '</td>' +
                    '<td>' + producto.Producto + '</td>' +
                    '<td>' + producto.Stock + '</td>' +
                    '<td>' + producto.PrecioCompra + '</td>' +
                    '<td>' + precioVenta + '</td>' +
                    '<td>' + precioMayorista + '</td>' +
                    '</tr>';
                tbody.append(row);
            });
        }

        function limpiarTablaProductos() {
            $('#ProductoDetalle tbody').empty();
        }

        function buscarProductoPorCodigo() {
            var codigo = $('#Prod_Id').val();
            if (codigo !== '') {
                $.ajax({
                    url: 'Services/TransferenciasService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'obtenerProductosPorCodigo',
                        Codigo: codigo
                    },
                    success: function(response) {
                        if (response && response.data && response.data.length > 0) {
                            llenarFormularioProducto(response.data[0]);
                        } else {
                            console.warn('Producto no encontrado');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener producto por código:', error);
                    }
                });
            }
        }

        function debounceBuscarProductoPorNombre() {
            clearTimeout(this.debounceTimeout);
            this.debounceTimeout = setTimeout(buscarProductoPorNombre, 300);
        }

        function buscarProductoPorNombre() {
            var nombre = $('#Prod_Nombre_').val();
            if (nombre !== '') {
                $.ajax({
                    url: 'Services/TransferenciasService.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'obtenerProductosPorCodigo',
                        Codigo: nombre
                    },
                    success: function(response) {
                        if (response && response.data && response.data.length > 0) {
                            llenarFormularioProducto(response.data[0]);
                        } else {
                            console.warn('Producto no encontrado');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error al obtener producto por nombre:', error);
                    }
                });
            }
        }

        function llenarFormularioProducto(producto) {
            $('#Prod_Id').val(producto.Codigo);
            $('#Prod_Nombre_').val(producto.Producto);
            $('#Prsx_Stock_').val(producto.Stock);
        }

        function limpiarFormularioProducto() {
            $('#Prod_Id').val('');
            $('#Prod_Nombre_').val('');
            $('#Prsx_Stock_').val('');
        }

        function submitForm() {
    var data = {
        action: 'transferir',
        Prod_Nombre_: $('#Prod_Nombre_').val(),
        Prsx_Stock_: $('#Prsx_Stock_').val(),
        Sucu_EnviadoId_: $('#SucursalEnvio').val(),
        Sucu_RecibidoId_: $('#SucursalRecibido').val()
    };
    console.log('Datos enviados:', data);
    if (validarFormulario(data)) {
        $.ajax({
            url: 'Services/TransferenciasService.php',
            type: 'POST',
            dataType: 'json',
            data: data,
            success: function(response) {
                if (response && response.result) {
                    iziToast.success({
                                                    title: 'Éxito',
                                                    message: 'Subido con éxito',
                                                    position: 'topRight',
                                                    transitionIn: 'flipInX',
                                                    transitionOut: 'flipOutX'
                                                });
                    limpiarTablaProductos();
                    limpiarFormularioProducto();
                } else {
                    iziToast.success({
                                                    title: 'Éxito',
                                                    message: 'Subido con éxito',
                                                    position: 'topRight',
                                                    transitionIn: 'flipInX',
                                                    transitionOut: 'flipOutX'
                                                });
                }
              
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error('Error en la transferencia:', error);
                iziToast.success({
                                                    title: 'Éxito',
                                                    message: 'Subido con éxito',
                                                    position: 'topRight',
                                                    transitionIn: 'flipInX',
                                                    transitionOut: 'flipOutX'
                                                });
          
                setTimeout(function() {
                    location.reload();
                }, 1000);
            }
        });
    }
}


        function validarFormulario(data) {
            var esValido = true;
            $('#SucursalEnvio_error, #SucursalRecibido_error,#Prod_Nombre_Error, #Prod_Nombre_Error, #Prsx_Stock_Error').hide(); 

            if (!data.Sucu_EnviadoId_) {
                $('#SucursalEnvio_error').text('Seleccione una sucursal de envío').show();
                
                esValido = false;
            }
            if (!data.Sucu_RecibidoId_) {
                $('#SucursalRecibido_error').text('Seleccione una sucursal de recibido').show();
                esValido = false;
            }
      
            if (!data.Prod_Nombre_) {
                $('#Prod_Nombre_Error').text('Producto vacío').show();
                esValido = false;
            }
            if (!data.Prsx_Stock_ || data.Prsx_Stock_ <= 0) {
                $('#Prsx_Stock_Error').text('Vacío, no puede ser menor a 0').show();
                esValido = false;
            }

            return esValido;
        }
    </script>
