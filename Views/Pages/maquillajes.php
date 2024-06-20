<div class="card">
    <div class="card-body">
    <h2 class="text-center" style="font-size: 90px !important">Maquillajes</h2>
    <div class="CrearOcultar" style="position:relative; top:-30px">
        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="TablaMaquillaje">
                <thead>
                    <tr>
                    <th>#</th>
                        <th>Codigo</th>
                        <th>Maquillaje</th>
                        <th>Imagen</th>
                        <th>Compra</th>
                        <th>Mayor</th>
                        <th>Venta</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        </div>

        <div class="CrearMostrar">
        <form id="quickForm" enctype="multipart/form-data">


        <div class="form-row">
            <div class="col-md-6">
            <label class="control-label">Proveedor</label>
            <select name="Prov_Id" class="form-control" id="Prov_Id" required></select>
            <div class="error-message" id="Prov_Id_error"></div>
            </div>

            <div class="col-md-6">
            <label class="control-label">Marca</label>
            <select name="Marc_Id" class="form-control" id="Marc_Id" required></select>
            <div class="error-message" id="Marc_Id_error"></div>
            </div>
        </div>

        <div class="form-row">
        <div class="col-md-6">
            <label class="control-label">Codigo</label>
            <input name="Codigo" class="form-control letras" id="Codigo"/>
            <span class="text-danger"></span>
            </div>
            <div class="col-md-6">
            <label class="control-label">Descripcion</label>
            <input name="Descripcion" class="form-control letras" id="Descripcion"/>
            <span class="text-danger"></span>
            </div>

         
        </div>

        <div class="form-row">
        <div class="col-md-6">
            <label class="control-label">Precio Compra</label>
            <input name="Compra" class="form-control letras" id="Compra"/>
            <span class="text-danger"></span>
            </div>
            <div class="col-md-6">
            <label class="control-label">Precio Venta</label>
            <input name="Venta" class="form-control letras" id="Venta"/>
            <span class="text-danger"></span>
            </div>

        </div>

        
        <div class="form-row">


            <div class="col-md-6">
            <label class="control-label">Precio Mayor</label>
            <input name="Mayor" class="form-control letras" id="Mayor"/>
            <span class="text-danger"></span>
            </div>
            <div class="col-md-6">
                <label class="control-label">Imagen</label>
                <input type="file" name="Imagen" class="form-control" id="Imagen" required/>

                <span class="text-danger"></span>
            </div>
        </div>
        <div class="card-body">
        <div class="form-row d-flex justify-content-end">
            <div class="col-auto">
                <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn"/>
            </div>
            <div class="col-auto">
                <a id="CerrarModal" class="btn btn-secondary" style="color:white">Cancelar</a>
            </div>
        </div>
</div>


</form>
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
                ¿Estás seguro de que deseas eliminar esta Marca?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Código de Barras -->
<div class="modal fade" id="codigoBarrasModal" tabindex="-1" aria-labelledby="codigoBarrasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content d-flex justify-content-center align-items-center">
            <div class="modal-header">
                <h5 class="modal-title" id="codigoBarrasModalLabel">Código de Barras</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group text-center">
                    <label for="cantidadCodigos">Cantidad de Códigos a Imprimir:</label>
                    <input type="number" class="form-control form-control-sm" id="cantidadCodigos" min="1" value="1">
                </div>
                <div class="barcode-container text-center" id="barcodeContainer">
                    <!-- Aquí se generan dinámicamente los códigos de barras -->
                </div>
                <div class="joya-nombre mt-3 text-center">
                    <!-- Aquí se mostrará el nombre de la joya -->
                    <h5 id="nombreJoya"></h5>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" id="generarCodigos">Generar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="imprimirCodigos">Imprimir</button>
            </div>
        </div>
    </div>
</div>

<div id="Detalles">
    <div class="row" style="padding: 10px;">
        <div class="col" style="font-weight:700">
            Codigo
        </div>
        <div class="col" style="font-weight:700">
            Maquillaje
        </div>
        <div class="col" style="font-weight:700">
            Precio Compra
        </div>
      
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col">
            <label for="" id="DetallesCodigo"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesMaquillaje"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesCompra"></label>
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col" style="font-weight:700">
            Precio Venta
        </div>
        <div class="col" style="font-weight:700">
            Precio Mayor
        </div>
        <div class="col" style="font-weight:700">
            Proveedor
        </div>
    </div>
    <div class="row" style="padding: 10px;">
        <div class="col">
            <label for="" id="DetallesVenta"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesMayor"></label>
        </div>
        <div class="col">
            <label for="" id="DetallesProveedor"></label>
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

                        <label for="" id="DetallesUsuarioCreacion"></label>
                        </td>
                        <td><label for="" id="DetallesFechaCreacion"></label></td>
                    </tr>
                    <tr>
                        <td>Modificar</td>
                        <td> <label for="" id="DetallesUsuarioModificacion"></label> </td>
                        <td>  <label for="" id="DetallesFechaModificacion"></label></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
    <div class="col d-flex justify-content-end m-3">
    <a class="btn btn-secondary" style="color:white" id="VolverDetalles">Cancelar</a>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
<script>
    $(document).ready(function () {

        $('#AbrirModal').click(function() {
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
        $('#quickForm').trigger('reset');
        $('#quickForm').validate().resetForm();
        sessionStorage.setItem('Maqu_Id', "0");
        });
        //DropDowns
        cargarDropdowns({ Prov_Id: 0, Marc_Id: 0 });
        async function cargarDropdowns(selectedData = {}) {
        try {
            const proveedores = await $.ajax({ url: 'Services/JoyasService.php', type: 'POST', data: { action: 'listarProveedores' } });
            const marcas = await $.ajax({ url: 'Services/MaquillajeService.php', type: 'POST', data: { action: 'listarMarcas' } });
            console.log(proveedores)
            const proveedorDropdown = $('#Prov_Id');
            const MarcaDropdown = $('#Marc_Id');
            proveedorDropdown.empty();
            MarcaDropdown.empty();
            proveedorDropdown.append('<option value="0">Seleccione una opción</option>');
            MarcaDropdown.append('<option value="0">Seleccione una opción</option>');
            JSON.parse(proveedores).data.forEach(proveedor => {
                proveedorDropdown.append('<option value="' + proveedor.Prov_Id + '">' + proveedor.Prov_Proveedor + '</option>');
            });
            if (selectedData.Prov_Id) {
                $('#Prov_Id').val(selectedData.Prov_Id);
            }

            JSON.parse(marcas).data.forEach(marcas => {
                MarcaDropdown.append('<option value="' + marcas.Marc_Id + '">' + marcas.Marc_Marca + '</option>');
            });
            if (selectedData.Marc_Id) {
                $('#Marc_Id').val(selectedData.Marc_Id);
            }


        } catch (error) {
            console.error('Error cargando dropdowns:', error);
        }
    }
    $.validator.addMethod("notZero", function (value, element) {
        return value !== "0";
    }, "Seleccione una opción válida.");

    //Validacion
        $('#quickForm').validate({
        rules: {
            Prov_Id: {
                required: true,
                notZero: true 
            },
            Marc_Id: {
                required: true,
                notZero: true 
            },Codigo: {
                required: true
            },Descripcion: {
                required: true
            },Compra: {
                required: true
            },Venta: {
                required: true
            },Mayor: {
                required: true
            },
       

        },
        messages: {
            Prov_Id: {
                required: "Por favor ingrese su Proveedor",
                notZero: "Por favor seleccione un Proveedor válido"
            },
            Marc_Id: {
                required: "Por favor ingrese su Marca",
                notZero: "Por favor seleccione una Marca válida"
            },Codigo: {
                required: "Por favor ingrese su Codigo"
            },Descripcion: {
              required: "Por favor ingrese su Descripcion"
            },Compra: {
                required: "Por favor ingrese su Compra"
            },Venta: {
               required: "Por favor ingrese su Venta"
            },Mayor: {
               required: "Por favor ingrese su Mayor"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-6').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

    //Inicio
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    $('#Detalles').hide();

   

    //Datatable
    var table = $('#TablaMaquillaje').DataTable({
    "ajax": {
        "url": "Services/MaquillajeService.php",
        "type": "POST",
        "data": function(d) {
            d.action = 'listarMaquillaje';
        },
        "dataSrc": function(json){
            console.log(json)
            return json.data;
        }
    },
    "columns": [
        { "data": null },
        { "data": "Maqu_Codigo" },
        { "data": "Maqu_Nombre" },
        {
            "data": "Maqu_Imagen",
            "render": function (data, type, row) {
                var imageUrl = '/PHPSistemaEsmeralda/Resources/uploads/maquillajes/' + encodeURIComponent(data);
                return '<img src="' + imageUrl + '" alt="Imagen de Maquillaje" width="50">';
            }
        },
        { "data": "Maqu_PrecioCompra" },
        { "data": "Maqu_PrecioVenta" },
        { "data": "Maqu_PrecioMayor" },
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
                    <a class="dropdown-item abrir-detalles" href="#"><i class="fas fa-eye"></i> Detalles</a>
                    <button class="dropdown-item abrir-eliminar"><i class="fas fa-eraser"></i> Eliminar</button>
                    <button class="dropdown-item abrir-generar-codigo"><i class="fas fa-barcode"></i>Etiquetas</button>
                </div>
            </div>
        </div>
    `
}

    ],
        "createdRow": function(row, data, dataIndex) {
      
        $('td:eq(0)', row).html(dataIndex + 1);
    }
    });

    $('#TablaMaquillaje tbody').on('click', '.abrir-generar-codigo', function() {
    var data = table.row($(this).parents('tr')).data();
    var codigo = data.Maqu_Codigo;
    var nombre = data.Maqu_Nombre; 

    
    if (!codigo || codigo.length < 1) {
        alert("El código es demasiado corto para generar un código de barras válido.");
        return;
    }

  
    $('#codigoBarrasModal').modal('show');


    $('#codigoBarrasModal').data('codigo', codigo);
    $('#codigoBarrasModal').data('nombre', nombre);


    $('#nombreJoya').text(nombre);


    generarCodigosBarras(codigo, nombre);
});


    function generarCodigosBarras(codigo) {
        var cantidad = parseInt($('#cantidadCodigos').val());

       
        $('#barcodeContainer').empty();

        // Generar los codigOs de barras
        for (var i = 0; i < cantidad; i++) {
            var svg = $('<svg class="barcode-item"></svg>');
            JsBarcode(svg[0], codigo, {
                format: "CODE128",
                displayValue: true,
                fontSize: 20,
                text: codigo
            });
            $('#barcodeContainer').append(svg);
        }
    }

    // boton codigos barras
    $('#generarCodigos').click(function() {
        var codigo = $('#codigoBarrasModal').data('codigo');
        generarCodigosBarras(codigo);
    });

    // imprimir
    $('#imprimirCodigos').click(function() {
        var printContents = document.getElementById('barcodeContainer').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        location.reload(); 
    });

    //cambia la cantidad de codigos
    $('#cantidadCodigos').change(function() {
        var codigo = $('#codigoBarrasModal').data('codigo');
        generarCodigosBarras(codigo);
    });



 //Abrir y Cerrar
   

    $('#CerrarModal').click(function() {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    });


    //Enviar o actualizar

    $('#guardarBtn').click(function() {
    if ($('#quickForm').valid()) {
        
        var Valor = sessionStorage.getItem('Maqu_Id');
        var Prov_Id = $('#Prov_Id').val()
        var Marc_Id = $('#Marc_Id').val()
        var Maqu_Nombre = $('#Descripcion').val()
        var Maqu_Codigo = $('#Codigo').val()
        var Maqu_PrecioCompra = $('#Compra').val()
        var Maqu_PrecioVenta = $('#Venta').val()
        var Maqu_PrecioMayor = $('#Mayor').val()
        var Maqu_Imagen = $('#Imagen')[0].files[0];

      
        var InsertarOActualizar = true
        if (Valor == "0") {
            InsertarOActualizar = true
        }else{
            InsertarOActualizar = false
        }

    var MaquillajeData = new FormData();
    var InsertarOActualizar = Valor == "0" ? true : false;

    MaquillajeData.append('action', InsertarOActualizar ? 'insertar' : 'actualizar');
    MaquillajeData.append('Maqu_Id', Valor);
    MaquillajeData.append('Maqu_Codigo', Maqu_Codigo);
    MaquillajeData.append('Maqu_Nombre', Maqu_Nombre);
    MaquillajeData.append('Maqu_PrecioCompra', Maqu_PrecioCompra);
    MaquillajeData.append('Maqu_PrecioVenta', Maqu_PrecioVenta);
    MaquillajeData.append('Maqu_PrecioMayor', Maqu_PrecioMayor);
    MaquillajeData.append('Maqu_Imagen', Maqu_Imagen);
    MaquillajeData.append('Prov_Id', Prov_Id);
    MaquillajeData.append('Marc_Id', Marc_Id);
    MaquillajeData.append('Maqu_FechaCreacion', new Date().toISOString().slice(0, 19).replace('T', ' '));
    MaquillajeData.forEach((value, key) => {
        console.log(key + ': ' + value);
    });
        $.ajax({
            url: 'Services/MaquillajeService.php',
            type: 'POST',
            data: MaquillajeData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response)
                response = JSON.parse(response); // Parse the JSON response
                if (response.result == 1) {
                    $('#quickForm').trigger('reset');
                    $('#quickForm').validate().resetForm();
                    sessionStorage.setItem('Maqu_Id', "0");
                    iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        $('#TablaMaquillaje').DataTable().ajax.reload();
            $('.CrearOcultar').show();
            $('.CrearMostrar').hide();
                } else {
                    iziToast.error({
            title: 'Error',
            message: 'No se pudo subir',
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


    $('#TablaMaquillaje tbody').on('click', '.abrir-editar', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#quickForm').trigger('reset');
        $('#quickForm').validate().resetForm();
        sessionStorage.setItem('Maqu_Id', data.Maqu_Id);

        // Cargar los dropdowns con los valores seleccionados
        cargarDropdowns({ Prov_Id: data.Prov_Id, Marc_Id: data.Marc_Id });

        // Llenar el formulario con los valores existentes
        $('#Codigo').val(data.Maqu_Codigo);
        $('#Descripcion').val(data.Maqu_Nombre);
        $('#Compra').val(data.Maqu_PrecioCompra);
        $('#Venta').val(data.Maqu_PrecioVenta);
        $('#Mayor').val(data.Maqu_PrecioMayor);


        // Mostrar el formulario de edición
        $('.CrearOcultar').hide();
        $('.CrearMostrar').show();
    });

    $('#TablaMaquillaje tbody').on('click', '.abrir-detalles', function () {
        var data = table.row($(this).parents('tr')).data();

        var valor = data.Maqu_Id;
        $('#Detalles').show();
        $('.CrearOcultar').hide();
        $('.CrearMostrar').hide();

        $.ajax({
            url: 'Services/MaquillajeService.php',
            method: 'POST',
            data: {
                action: 'buscar',
                Maqu_Id: valor
            },
            success: function(response) {
                var parsedResponse = JSON.parse(response);
                console.log("Parsed Response:", parsedResponse);

          
                var data = parsedResponse.data[0];
                console.log("Data:", data);

                $('#DetallesUsuarioCreacion').text(data.UsuarioCreacion || 'N/A');
                $('#DetallesUsuarioModificacion').text(data.UsuarioModificacion || 'N/A');
                $('#DetallesFechaModificacion').text(data.FechaModificacion || 'N/A');
                $('#DetallesFechaCreacion').text(data.FechaCreacion || 'N/A');
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

    $('#TablaMaquillaje tbody').on('click', '.abrir-eliminar', function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(data);
        var Maqu_Id = data.Maqu_Id;
        sessionStorage.setItem('Maqu_Id', Maqu_Id);
        $('#eliminarModal').modal('show');
        });

        $('#confirmarEliminarBtn').click(function() {
        var Maqu_Id = sessionStorage.getItem('Maqu_Id');
        $.ajax({
            url: 'Services/MaquillajeService.php',
            type: 'POST',
            data: {
                action: 'eliminar',
                Maqu_Codigo: Maqu_Id
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
                    $('#TablaMaquillaje').DataTable().ajax.reload();
                    $('#eliminarModal').modal('hide');
                    sessionStorage.setItem('Maqu_Id', "0");
                } else {
                    alert('Error al eliminar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    });   

    });
</script>