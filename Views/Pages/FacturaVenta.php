
<style>
        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            text-align: center;
            display: flex;
            justify-content: center;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100%;
        }

        .dataTables_wrapper .dataTables_filter label {
            width: 80%; 
        }
        .ui-autocomplete {
        z-index: 1050; 
        }

    </style>
 <script>
        $(document).ready(function() {
          sessionStorage.setItem("Clie_Id","1")
          sessionStorage.setItem("Mayorista","0")
            var availableTags = [];
            
            // Cargar datos de la base de datos
            $.ajax({
                url: 'Services/FacturaService.php',
                type: 'POST',
                data: { action: 'listarClientes' },
                dataType: 'json',
                success: function(response) {
                    if (response.data) {
                        availableTags = response.data;
                        
                        $("#tags").autocomplete({
                            source: function(request, response) {
                                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                                response($.grep(availableTags, function(value) {
                                    return matcher.test(value.label);
                                }));
                            },
                            select: function(event, ui) {
                                
                                var selectedObj = ui.item;
                                console.log(selectedObj);
                                if (selectedObj.mayorista == "No") {
                                  sessionStorage.setItem("Mayorista","0")
                                }else{
                                  sessionStorage.setItem("Mayorista","1")
                                }
                                sessionStorage.setItem("Clie_Id",selectedObj.id)
                                $('#TablaProductos_Factura').DataTable().ajax.reload();
                            }
                        });
                    } else if (response.error) {
                        console.error(response.error);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener datos: ' + error);
                }
            });
        });
    </script>
<div class="card">
  <div class="card-body">
    <h2 class="text-center" style="font-size: 34px !important">Facturas</h2>

    <div class="form-row">
    <div class="col-md-8">
      <label for="">Cliente</label>
        <div class="input-group mb-3">
        <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-check"></i></span>
        </div>
                  <input type="text" class="form-control" id="tags" placeholder="Consumidor Final">
        </div>
        <div class="form-row"  style="justify-content: space-between; margin: 0px 10px">
        <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block" id="btnEfectivo">
              <i class="fas fa-dollar-sign"></i> Efectivo
            </button>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block" id="btnTarjeta">
              <i class="fas fa-credit-card"></i>Tarjeta de credito
            </button>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block" id="btnTransferencias">
              <i class="fas fa-donate"></i> Transferencias
            </button>
          </div>
        </div>
    </div>
    <div class="col-md-4">
      <div style="height:100%; background-color: #4e7ed4;display:flex;justify-content:center; align-items:center">
        <span style="color:#17358D;font-size:40px; text-shadow:0px 10px 10px #17358D;font-weight:900" id="txtTotal">00.0</h2>
      </div>
    </div>
</div>
  

    <div class="CrearMostrar">
      <form id="FacturaForm" style="width: 100%">
        <div class="form-row" style="justify-content: center; margin: 10px 0px">
          <div class="col-md-12">
          <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-qrcode"></i>
                    </span>
                  </div>
                  <input type="text" class="form-control" id="auto">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-secondary btn-block btn-sm" id="btnSeleccionarProducto">
              <i class="fas fa-plus"></i> Seleccione producto
            </button>
                  </div>
                </div>
          </div>
       
        </div>
       
        <div
          class="form-row"
          style="justify-content: space-between; margin: 0px 10px"
        >
          <div class="col-md-12" style="margin-top:10px">
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="TablaProductos_Factura">
                <thead>
                  <tr>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </form>
      <div
          class="form-row"
          style="justify-content: end; margin: 0px 10px"
        >
          <div class="col-md-2">
            <button type="button" class="btn btn-secondary btn-block" id="btnNuevo">
              <i class="fas fa-plus"></i> Nuevo
            </button>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-secondary btn-block" id="btnConfirmar">
              <i class="far fa-check-circle"></i>Confirmar
            </button>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-secondary btn-block" id="btnCancelar">
              <i class="fas fa-reply"></i> Cancelar
            </button>
          </div>
        </div>
    </div>
  
    <!-- Cierre de CrearMostrar -->
  </div>
  <!-- Cierre de card-body -->
</div>

<div class="modal fade" id="ModalListaProductos" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Add modal-lg class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Lista Productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="tablaProductos" style="width: 100%;">
                <thead>
                  <tr>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            
              </table>
      </div>
      <div style="height: 20px; width:10px"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalConfirmar" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Add modal-lg class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Total a pagar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div style="padding: 10px 10px;">
              <div class="form-row ">
                <div class="col-md-6">
                  <label class="control-label">Monto Recibido</label>
                  <input name="Monto" class="form-control letras" id="Monto"/>
                  <span class="text-danger"></span>
                </div>
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalTransferencias" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Add modal-lg class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Tarjeta de banco</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div style="padding: 10px 10px;">
              <div class="form-row ">
                <div class="col-md-6">
                  <label class="control-label">Monto Recibido</label>
                  <select name="Tarj_Id" class="form-control" id="Tarj_Id" required></select>
                  <span class="text-danger"></span>
                </div>
            </div>
          </div>
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminarBtn">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalReparacion" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Add modal-lg class here -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Especificacion de producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="FormReparacion">
          <div style="padding: 10px 10px;">
              <div class="form-row ">
                <div class="col-md-6">
                  <label class="control-label">Descripcion</label>
                  <input name="DescripcionRepa" class="form-control letras" id="DescripcionRepa"/>
                  <span class="text-danger"></span>
                </div>
                <div class="col-md-6">
                  <label class="control-label">Precio</label>
                  <input name="PrecioRepa" class="form-control letras" id="PrecioRepa"/>
                  <span class="text-danger"></span>
                </div>
              </div>
          </div>
          </form>
          <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarReparacion">Enviar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<script>
$(document).ready(function() {

  sessionStorage.setItem("Fact_Id","0")
  sessionStorage.setItem("Cantidad","1")

  cargarDropdowns({ Tarj_Id: 0 });
        async function cargarDropdowns(selectedData = {}) {
        try {
            const Tarjetas = await $.ajax({ url: 'Services/FacturaService.php', type: 'POST', data: { action: 'listartarjetas' } });
            const TarjetaDropdown = $('#Tarj_Id');
            console.log("Entra xD")
            console.log(Tarjetas)
            TarjetaDropdown.empty();

            TarjetaDropdown.append('<option value="0">Seleccione una opción</option>');
         

       


        } catch (error) {
            console.error('Error cargando dropdowns:', error);
        }
    }


  sessionStorage.setItem("Mepa_Metodo", "1")
        $("#btnEfectivo").removeClass("btn-secondary")
        $("#btnEfectivo").addClass("btn-primary")

    //Seleccionado de btn
    $("#btnEfectivo").click(function () {
        sessionStorage.setItem("Mepa_Metodo", "1")
        $("#btnEfectivo").removeClass("btn-secondary")
        $("#btnEfectivo").addClass("btn-primary")

        $("#btnTarjeta").removeClass("btn-primary")
        $("#btnTarjeta").addClass("btn-secondary")
    
        $("#btnTransferencias").removeClass("btn-primary")
        $("#btnTransferencias").addClass("btn-secondary")
    })
    
    $("#btnTarjeta").click(function () {
        sessionStorage.setItem("Mepa_Metodo", "4")
        $("#btnTarjeta").removeClass("btn-secondary")
        $("#btnTarjeta").addClass("btn-primary")

        $("#btnEfectivo").removeClass("btn-primary")
        $("#btnEfectivo").addClass("btn-secondary")

        $("#btnTransferencias").removeClass("btn-primary")
        $("#btnTransferencias").addClass("btn-secondary")
    })

    $("#btnTransferencias").click(function () {
        sessionStorage.setItem("Mepa_Metodo", "7")
        $("#btnTransferencias").removeClass("btn-secondary")
        $("#btnTransferencias").addClass("btn-primary")

        $("#btnEfectivo").removeClass("btn-primary")
        $("#btnEfectivo").addClass("btn-secondary")

        $("#btnTarjeta").removeClass("btn-primary")
        $("#btnTarjeta").addClass("btn-secondary")

    })


    $('#auto').on('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault(); 
                    console.log($('#auto').val())
                    sessionStorage.setItem("Cantidad","1")
                    $.ajax({
            url: 'Services/FacturaService.php',
            method: 'POST',
            data: {
                action: 'buscarCodigo',
                Codigo: $('#auto').val()
            },
            success: function(response) {
              var data = JSON.parse(response);
              console.log(data); 

              if (data && data.data && data.data.length > 0) {

                  var marca = data.data[0];
                  var valor = "1"
                  if (data.data[0].Categoria == "Joyas") {
                    valor = 1;
                  }else {
                    valor = 2;
                  }
                  console.log("El valor es" + valor)
          

                  $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'insertarprimero',
                Clie_Id: sessionStorage.getItem("Clie_Id"),
                Mepa_Id: sessionStorage.getItem("Mepa_Metodo"), 
                Fact_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_Codigo: sessionStorage.getItem("Fact_Id"),
                Faxd_Diferenciador: valor,
                Prod_Nombre: data.data[0].Producto,
                Faxd_Cantidad: sessionStorage.getItem("Cantidad")
            },
            success: function(response) {
              console.log(response)
              var parsedResponse = JSON.parse(response);
        var data = parsedResponse.data;
        if (data[0].TotalStock != 0 && data[0].Resultado == 1) {
            iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        sessionStorage.setItem("Fact_Id", data[0].TotalStock)
        console.log(sessionStorage.getItem("Fact_Id"));

$('#TablaProductos_Factura').DataTable().ajax.reload(); 
        $('#tablaProductos').DataTable().ajax.reload();

                } else {
                    iziToast.error({
            title: 'Error',
            message: 'Stock insuficiente' + data[0].TotalStock,
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
        




              } else {
                alert("No hay datos")
              }

            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
                    // Puedes agregar aquí cualquier otra acción que desees ejecutar
                }
            });
 

    $('#btnSeleccionarProducto').click(function(){
        $("#ModalListaProductos").modal("show")
    })

    var table = $('#tablaProductos').DataTable({
    "ajax": {
        "url": "Services/FacturaService.php",
        "type": "POST",
        "data": {
            "action": 'listarProductos'
        },
        "dataSrc": function(json) {
            console.log(json.data);
            return json.data;
        }
    },
    "pageLength": 5, // Establece el número de filas por página
    "lengthChange": false, // Deshabilita la opción de cambiar el número de filas por página
    "columns": [
        { "data": "Categoria" },
        { "data": "Codigo" },
        { "data": "Producto" },
        { "data": "PrecioVenta" },
        { "data": "Stock" },
        { 
            "data": null, 
            "defaultContent": "<div class='text-center'><a class='btn btn-primary btn-sm añadir-item' style='border-radius: 20px;'><i class='fas fa-plus'></i></a></div>"

        }
    ],
    "dom": '<"top"f>rt<"bottom"p><"clear">' // Ubica el buscador en la parte superior
});
$.validator.addMethod("notZero", function(value, element) {
    return value !== "0" && value !== "";
}, "La cantidad no puede ser 0 o vacía.");
var tableProductos = $('#TablaProductos_Factura').DataTable({
    "ajax": {
        "url": "Services/FacturaService.php",
        "type": "POST",
        "data":  function(d){
            d.action = 'listarproductos_Factura';
            d.fact_Id = sessionStorage.getItem("Fact_Id");
            d.mayorista =sessionStorage.getItem("Mayorista");
                  },
        "dataSrc": function(json) {
            console.log(json.data);
            return json.data;
        }
    },
    "pageLength": 5, 
    "lengthChange": false, 
    "columns": [
        { "data": "Categoria" },
        { "data": "Prod_Codigo" },
        { "data": "Producto" },
        { "data": "Precio_Unitario" },
        {
            "data": "Cantidad",
            "render": function(data, type, row) {
                return '<form class="cantidad-form" id="form_cantidad_' + row.Prod_Codigo + '"><input type="number" name="cantidad_' + row.Prod_Codigo + '" class="form-control cantidad-input" value="' + data + '" /></form>';
            }
        },
        { "data": "Total" },
        { 
            "data": null, 
            "defaultContent": "<div class='text-center'><a class='btn btn-danger btn-sm eliminar-item' style='border-radius: 20px;'><i class='fas fa-trash'></i></a></div>"

        }
    ],
    "dom": 'rt<"bottom"p><"clear">' // Excluye el buscador
});



$('#tablaProductos tbody').on('click', '.añadir-item', function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(data);
        sessionStorage.setItem("Cantidad","1")
        if (data.Categoria == "Joyas" || data.Categoria == "Maquillajes") {
            var valor = "1"
          if (data.Categoria == "Joyas") {
            valor = 1;
          }else {
            valor = 2;
          }
          console.log(valor)

          $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'insertarprimero',
                Clie_Id: sessionStorage.getItem("Clie_Id"),
                Mepa_Id: sessionStorage.getItem("Mepa_Metodo"), 
                Fact_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_Codigo: sessionStorage.getItem("Fact_Id"),
                Faxd_Diferenciador: valor,
                Prod_Nombre: data.Producto,
                Faxd_Cantidad: sessionStorage.getItem("Cantidad")
            },
            success: function(response) {
              console.log(response)
              var parsedResponse = JSON.parse(response);
        var data = parsedResponse.data;
        if (data[0].TotalStock != 0 && data[0].Resultado == 1) {
            iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        sessionStorage.setItem("Fact_Id", data[0].TotalStock)
        console.log(sessionStorage.getItem("Fact_Id"));

$('#TablaProductos_Factura').DataTable().ajax.reload(); 
        $('#tablaProductos').DataTable().ajax.reload();

                } else {
                    iziToast.error({
            title: 'Error',
            message: 'Stock insuficiente' + data[0].TotalStock,
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


        }else{
          sessionStorage.setItem("Diferenciador", "3")
          sessionStorage.setItem("Codigo", data.Codigo)
          $("#ModalListaProductos").modal("hide")
          $("#ModalReparacion").modal("show");
          $("#DescripcionRepa").val(null)
          $("#PrecioRepa").val(null)
        }
        

        
       
        
       
  

       
       
    });   


  $("#btnConfirmar").click(function () {
    if (sessionStorage.getItem("Mepa_Metodo") == "1") {
      $("#ModalConfirmar").modal("show");
    }else if(sessionStorage.getItem("Mepa_Metodo") == "7"){
      $("#ModalTransferencias").modal("show")

    }else{
      alert("es xd")
    }
  
  })
  $('#FormReparacion').validate({
        rules: {
            DescripcionRepa: {
                required: true
            },
            PrecioRepa: {
                required: true
            }
        },
        messages: {
          DescripcionRepa: {
                required: "Por favor ingrese una descripcion"
            },  
            PrecioRepa: {
                required: "Por favor ingrese un precio"
            },

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
  $("#confirmarReparacion").click(function () {
    if ($('#FormReparacion').valid()) {




    }
  
  })

  $('#TablaProductos_Factura tbody').on('keydown', '.cantidad-input', function(e) {
    if (e.key === 'Tab') {
        e.preventDefault(); // Prevenir el comportamiento por defecto del tab
        var $input = $(this);
        var $form = $input.closest('form');
        var inputName = $input.attr('name');
        
        $form.validate({
            rules: {
                [inputName]: {
                    required: true,
                    notZero: true
                }
            },
            messages: {
                [inputName]: {
                    required: "La cantidad es requerida.",
                    notZero: "La cantidad no puede ser 0."
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.cantidad-form').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Si el formulario es válido, ejecutar la acción
        if ($form.valid()) {
            var value = $input.val();
            var row = tableProductos.row($input.closest('tr')).data();
            console.log("Cantidad válida: " + value);
            console.log("Fila: ", row);
            var valor = "1"
        if (row.Categoria == "Joyas") {
          valor = 1;
        }else {
          valor = 2;
         }

        console.log(valor)
        $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'insertardespues',
                Clie_Id: sessionStorage.getItem("Clie_Id"),
                Mepa_Id: sessionStorage.getItem("Mepa_Metodo"), 
                Fact_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_Codigo: sessionStorage.getItem("Fact_Id"),
                Faxd_Diferenciador: valor,
                Prod_Nombre: row.Producto,
                Faxd_Cantidad: value
            },
            success: function(response) {
              console.log(response)
              var parsedResponse = JSON.parse(response);
        var data = parsedResponse.data;
        if (data[0].TotalStock != 0 && data[0].Resultado == 1) {
            iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        sessionStorage.setItem("Fact_Id", data[0].TotalStock)
        console.log(sessionStorage.getItem("Fact_Id"));

$('#TablaProductos_Factura').DataTable().ajax.reload(); 
        $('#tablaProductos').DataTable().ajax.reload();

                } else {
                    iziToast.error({
            title: 'Error',
            message: 'Stock insuficiente' + data[0].TotalStock,
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
            
        } else {
            $input.focus(); // Mantener el foco en el input
        }
    }
});
$('#TablaProductos_Factura tbody').on('click', '.eliminar-item', function () {
        var data = tableProductos.row($(this).parents('tr')).data();
        console.log(data.Producto);

        $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'eliminarDetalle',
                'Fact_Codigo': sessionStorage.getItem("Fact_Id"),
                'Sucu_Codigo': 1,
                'Prod_Nombre_Codigo':data.Producto
            },
            success: function(response) {
              console.log(response)
        if (response == 1) {
            iziToast.success({
            title: 'Éxito',
            message: 'Eliminado con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });


$('#TablaProductos_Factura').DataTable().ajax.reload(); 
$('#tablaProductos').DataTable().ajax.reload();

                } else {
                    iziToast.error({
            title: 'Error',
            message: 'No se logro eliminar',
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
        
       


       
       
    });   
});



</script> 

