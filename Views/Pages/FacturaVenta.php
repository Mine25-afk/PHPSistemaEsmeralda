<style>
        .dataTables_wrapper .dataTables_filter {
            width: 100%;
            text-align: left;
        }

        .dataTables_wrapper .dataTables_filter input {
            width: 100%; /* Ajusta el ancho del input del buscador */
        }

        .dataTables_wrapper .dataTables_filter label {
            width: 80%; /* Ajusta el ancho del input del buscador */
        }
    </style>
 <script>
        $(document).ready(function() {
            var availableTags = [];
            
            // Cargar datos de la base de datos
            $.ajax({
                url: 'Controllers/FacturaController.php',
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
                                alert('Nombre: ' + selectedObj.nombre + '\nMayorista: ' + (selectedObj.mayorista ? 'Sí' : 'No'));
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

    <div style="height:91px; background-color: #4e7ed4;display:flex;justify-content:center; align-items:center">
        <span style="color:#5d9e3e;font-size:40px; text-shadow:0px 10px 10px #2f46c2;font-weight:900" id="txtTotal">00.0</h2>
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
                <tfoot>
                  <tr>
                    <td>Categoria</td>
                    <td>
                      <input
                        name="Marca"
                        class="form-control letras"
                        id="tags"
                        
                      />
                    </td>
                    <td>
                      <input
                        name="Marca"
                        class="form-control letras"
                        id="Marca"
                      />
                    </td>
                    <td>100</td>
                    <td>3</td>
                    <td>300</td>
                  </tr>
                </tfoot>
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
     
                <table class="table table-striped table-hover" id="tablaProductos">
                <thead>
                  <tr>
                    <th>Categoria</th>
                    <th>Codigo</th>
                    <th>Producto</th>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
            
              </table>
      
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarFacturaBTN">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<script>
$(document).ready(function() {

    $('#auto').on('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault(); // Evita que el navegador realice la acción predeterminada de la tecla Tab
                    // Ejecuta la acción deseada
                    alert('Tab key pressed! Action executed.');
                    // Puedes agregar aquí cualquier otra acción que desees ejecutar
                }
            });
    $('#txtTotal').text("100.00")

    $('#btnSeleccionarProducto').click(function(){
        $("#ModalListaProductos").modal("show")
    })

    var table = $('#tablaProductos').DataTable({
    "ajax": {
        "url": "Controllers/FacturaController.php",
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
            "defaultContent": "<a class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i> Editar</a>"
        }
    ],
    "dom": '<"top"f>rt<"bottom"p><"clear">' // Ubica el buscador en la parte superior
});




});



</script> 

