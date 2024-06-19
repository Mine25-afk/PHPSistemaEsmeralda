
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
              <table class="table table-striped table-hover">
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
                  <tr>
                    <td>Maquillaje</td>
                    <td>M1004</td>
                    <td>Labial</td>
                    <td>300.34</td>
                    <td>3</td>
                    <td>1000</td>
                    <td>
                      <button type="button" class="btn btn-secondary btn-block">
                        <i class="fas fa-eraser"></i>
                      </button>
                    </td>
                  </tr>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<script>
$(document).ready(function() {

  sessionStorage.setItem("Fact_Id","0")
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
                    e.preventDefault(); // Evita que el navegador realice la acción predeterminada de la tecla Tab
                    // Ejecuta la acción deseada
                    console.log($('#auto').val())
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
                  alert("Hay datos")
                  var marca = data.data[0];
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

            },
            success: function(response) {
          console.log(response)
          if (response != 0) {
            iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        sessionStorage.setItem("Fact_Id", response)
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
    $('#txtTotal').text("100.00")

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

$('#tablaProductos tbody').on('click', '.añadir-item', function () {
        var data = table.row($(this).parents('tr')).data();
        console.log(data);
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

            },
            success: function(response) {
          console.log(response)
          if (response != 0) {
            iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });
        sessionStorage.setItem("Fact_Id", response)
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


});



</script> 

