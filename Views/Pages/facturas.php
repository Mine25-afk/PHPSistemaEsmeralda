<script>
$(document).ready(function() {
    var availableTags = [
  { label: "061120050073 - 1", value: "061120050073" },
  { label: "0711 - 2", value: "0711" },
  { label: "60 - 3", value: "60" },
  // ... otros datos ...
  { label: "DNI_Random_1 - ID_Random_1", value: "DNI_Random_1" },
  { label: "DNI_Random_2 - ID_Random_2", value: "DNI_Random_2" },
  // ... más datos aleatorios ...
];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
    $("#tags").autocomplete({
  source: function(request, response) {
    var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
    response($.grep(availableTags, function(value) {
      return matcher.test(value.label);
    }));
  }
});
  } );
  </script>
<div class="card">
  <div class="card-body">
    <h2 class="text-center" style="font-size: 34px !important">Facturas</h2>

    <div class="CrearOcultar">
      <p class="btn btn-primary" id="AbrirModal">Nuevo</p>
      <hr />
      <div class="table-responsive">
        <table class="table table-striped table-hover" id="tablaFactura">
          <thead>
            <tr>
              <th>ID</th>
              <th>Cliente</th>
              <th>Método de Pago</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>

    <div class="CrearMostrar">
      <form id="FacturaForm" style="width: 100%">
        <div class="form-row" style="justify-content: center; margin: 0px 10px">
          <div class="col-md-6">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-address-book"></i
                ></span>
              </div>
              <input id="tags" placeholder="DNI" class="form-control">
            
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"
                  ><i class="fas fa-child"></i
                ></span>
              </div>
              <input
                type="email"
                class="form-control"
                placeholder="Consumidor Final"
              />
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
                        id="Marca"
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

<!-- Modal Confirmar -->
<div class="modal fade" id="ConfirmarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Quieres confirmar este registro?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="SiesEfectivo" style="margin: 10px;">
            <form id="ConfirmarPago" enctype="multipart/form-data">
            <div class="form-row">
                <div class="col-md-6">
                <label class="control-label">Pago</label>
                <input name="Pago" class="form-control letras" id="Pago"/>
                <span class="text-danger"></span>
                </div>
            </div>
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarFacturaBTN">Eliminar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();
    var table = $('#tablaFactura').DataTable({
        "ajax": {
            "url": "Services/FacturaService.php",
            "type": "POST",
            "data": {
                "action": 'listarFactura'
            },
            "dataSrc": function(json) {
                return json.data;
            }
        },
        "columns": [
            { "data": "Fact_Id" },
            { "data": "Clie_Nombre" },
            { "data": "Mepa_Metodo" },
            { "data": "Acciones" },
        ]
    });

    $('#tablaFactura tbody').on('click', '.abrir-confirmar', function () {
        var data = table.row($(this).parents('tr')).data();
        var Fact_Id = data.Fact_Id;
        sessionStorage.setItem('Fact_Id', Fact_Id);
        $('#ConfirmarModal').modal('show');
        });

        $('#confirmarFacturaBTN').click(function() {
        var Fact_Id = sessionStorage.getItem('Fact_Id');
        $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'confirmar',
                Fact_Codigo: Fact_Id,
                Fact_FechaFinalizado:  new Date().toISOString().slice(0, 19).replace('T', ' '),
                Fact_Pago: $("#Pago").val(),
                Fact_Cambio:  $("#Pago").val()
            },
            success: function(response) {
                if (response == 1) {
                    iziToast.success({
                        title: 'Éxito',
                        message: 'Confirmado con éxito',
                        position: 'topRight',
                        transitionIn: 'flipInX',
                        transitionOut: 'flipOutX'
                    });
                    $('#tablaFactura').DataTable().ajax.reload();
                    $('#ConfirmarModal').modal('hide');
                    sessionStorage.setItem('Fact_Id', "0");
                } else {
                    alert('Error al eliminar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    });   

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

    $("#btnNuevo").click(function () {
        //Metodo
        sessionStorage.setItem("Mepa_Metodo", "1")
        $("#btnEfectivo").removeClass("btn-secondary")
        $("#btnEfectivo").addClass("btn-primary")
        $("#btnTarjeta").removeClass("btn-primary")
        $("#btnTarjeta").addClass("btn-secondary")
        $("#btnTransferencias").removeClass("btn-primary")
        $("#btnTransferencias").addClass("btn-secondary")

        //
    })

    $("#btnCancelar").click(function () {
        //Metodo
        sessionStorage.setItem("Mepa_Metodo", "1")
        $("#btnEfectivo").removeClass("btn-secondary")
        $("#btnEfectivo").addClass("btn-primary")
        $("#btnTarjeta").removeClass("btn-primary")
        $("#btnTarjeta").addClass("btn-secondary")
        $("#btnTransferencias").removeClass("btn-primary")
        $("#btnTransferencias").addClass("btn-secondary")

        //Collapase
        $('.CrearOcultar').show();
        $('.CrearMostrar').hide();
    })


    $("#btnConfirmar").click(function () {
        //Metodo
        sessionStorage.setItem("Mepa_Metodo", "1")
        $("#btnEfectivo").removeClass("btn-secondary")
        $("#btnEfectivo").addClass("btn-primary")
        $("#btnTarjeta").removeClass("btn-primary")
        $("#btnTarjeta").addClass("btn-secondary")
        $("#btnTransferencias").removeClass("btn-primary")
        $("#btnTransferencias").addClass("btn-secondary")

        //Collapase
        $('.CrearOcultar').show();
        $('.CrearMostrar').hide();

        var doc = new jsPDF();
        doc.text('Hola, este es un PDF generado desde JavaScript con JsPdf', 10, 10);
        doc.save('archivo.pdf');
    })








    $('#tablaFactura tbody').on('click', '.abrir-detalles', function () {
        console.log("HOLA")
        var doc = new jsPDF();
        doc.text('Hola, este es un PDF generado desde JavaScript con JsPdf', 10, 10);
        doc.save('archivo.pdf');
    });





    $('#AbrirModal').click(function() {
    $('.CrearOcultar').hide();
    $('.CrearMostrar').show();
    sessionStorage.setItem('Fact_Id', "0");
    });
});



</script> 

