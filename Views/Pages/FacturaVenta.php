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

  #pdf-frame {
    display: none;
    /* Ocultar el iframe */
  }
</style>
<script>
  $(document).ready(function() {
    sessionStorage.setItem("Clie_Id", "1")
    sessionStorage.setItem("Mayorista", "0")
    var availableTags = [];

    // Cargar datos de la base de datos
    $.ajax({
      url: 'Services/FacturaService.php',
      type: 'POST',
      data: {
        action: 'listarClientes'
      },
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
                sessionStorage.setItem("Mayorista", "0")
              } else {
                sessionStorage.setItem("Mayorista", "1")
              }
              sessionStorage.setItem("Clie_Id", selectedObj.id)
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
    <h2 class="text-center" style="font-size: 90px !important">Facturas</h2>

    <div class="form-row">
      <div class="col-md-8">
        <label for="">Cliente</label>
        <div class="input-group mb-3">
          <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-check"></i></span>
          </div>
          <input type="text" class="form-control" id="tags" placeholder="Consumidor Final">
        </div>
        <div class="form-row" style="justify-content: space-between; margin: 0px 10px">
          <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block" id="btnEfectivo">
              <i class="fas fa-dollar-sign"></i> Efectivo
            </button>
          </div>
          <div class="col-md-5">
            <button type="button" class="btn btn-secondary btn-block" id="btnTarjeta" style="color: white;">
              <i class="fas fa-credit-card"></i> Tarjeta de credito
            </button>
          </div>
          <div class="col-md-3">
            <button type="button" class="btn btn-secondary btn-block" id="btnTransferencias" style="color: white;">
              <i class="fas fa-donate"></i> Transferencias
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div style="height:100%; background-color: #5d9e3e;display:flex;justify-content:center; align-items:center">
          <span style="color:#FFF;font-size:40px; text-shadow:0px 10px 10px #000000;font-weight:900" id="txtTotal">00.0</h2>
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
                <button type="button" class="btn btn-secondary btn-block btn-sm" id="btnSeleccionarProducto" style="color: white;">
                  <i class="fas fa-plus"></i> Seleccione producto
                </button>
              </div>
            </div>
          </div>

        </div>

        <div class="form-row" style="justify-content: space-between; margin: 0px 10px">
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
      <div class="form-row" style="justify-content: end; margin: 0px 10px">
        <div class="col-md-6" style="display: flex; flex-direction:column; justify-content: end">
          <label for="" style="text-align: end;font-size:24px" id="txtSubtotal">Subtotal:00.0</label>
          <label for="" style="text-align: end;font-size:24px" id="txtImpuesto">Impuesto:00.0</label>
          <label for="" style="text-align: end;font-size:28px" id="txtTotal2">Total:00.0</label>
        </div>


      </div>

      <div class="form-row" style="justify-content: end; margin: 0px 10px">
        <div class="col-md-2">
          <button type="button" class="btn btn-secondary btn-block" style="color: white;" id="btnNuevo">
            <i class="fas fa-plus"></i> Nuevo
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-secondary btn-block" style="color: white;" id="btnConfirmar">
            <i class="far fa-check-circle"></i>Confirmar
          </button>
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-secondary btn-block" style="color: white;" id="btnCancelar">
            <i class="fas fa-reply"></i> Listar
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
        <form id="Form_Efectivo">
          <div class="form-row ">
            <div class="col-md-6">
              <label class="control-label">Monto Recibido</label>
              <input name="MontoEfectivo" class="form-control letras" id="MontoEfectivo" />
              <span class="text-danger"></span>
            </div>
            <div class="col-md-6" style="display:flex;justify-content: center; align-items:center">
              <label class="control-label" id="Cambio" style="font-size: 30px;">00.0</label>
              <span class="text-danger"></span>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="ConfirmarEfectivo">Enviar</button>
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
        <form id="Tarjeta_Form">
          <div class="form-row ">
            <div class="col-md-6">
              <label class="control-label">Tarjeta</label>
              <select name="Tarj_Id" class="form-control" id="Tarj_Id" required></select>
              <span class="text-danger"></span>
            </div>
            <div class="col-md-6">
              <label class="control-label">Codigo</label>
              <input name="CodigoTransferencia" class="form-control letras" id="CodigoTransferencia" />
              <span class="text-danger"></span>
            </div>
        </form>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      <button type="button" class="btn btn-primary" id="ConfirmarTarjeta">Enviar</button>
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
              <input name="DescripcionRepa" class="form-control letras" id="DescripcionRepa" />
              <span class="text-danger"></span>
            </div>
            <div class="col-md-6">
              <label class="control-label">Precio</label>
              <input name="PrecioRepa" class="form-control letras" id="PrecioRepa" />
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
<iframe id="pdf-frame"></iframe>


<script>
  $(document).ready(function() {
    sessionStorage.getItem("Validacion","1")
    $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'validacion',
                FechaHoy: new Date().toISOString().slice(0, 19).replace('T', ' ')
            },
            success: function(response) {
                console.log(response)
                if (response == 0) {
                  $('#AbrirCajaModal').modal('show');
                }else{
                 
                }
      
               
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
    sessionStorage.setItem("Fact_Id", "0")
    sessionStorage.setItem("Total", "0")
    sessionStorage.setItem("Cantidad", "1")

    cargarDropdowns({
      Tarj_Id: 0
    });
    async function cargarDropdowns(selectedData = {}) {
      try {
        const response = await $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'listartarjetas'
          }
        });

        const tarjetas = JSON.parse(response).data;
        const tarjetaDropdown = $('#Tarj_Id');

        tarjetaDropdown.empty();
        tarjetaDropdown.append('<option value="0">Seleccione una opción</option>');

        tarjetas.forEach(tarjeta => {
          tarjetaDropdown.append(`<option value="${tarjeta.tarj_id}">${tarjeta.tarj_Descripcion}</option>`);
        });

        // Si hay datos seleccionados previamente, seleccionarlos
        if (selectedData.Tarj_Id) {
          tarjetaDropdown.val(selectedData.Tarj_Id);
        }
      } catch (error) {
        console.error('Error cargando dropdowns:', error);
      }
    }


    sessionStorage.setItem("Mepa_Metodo", "1")
    $("#btnEfectivo").removeClass("btn-secondary")
    $("#btnEfectivo").addClass("btn-primary")

    //Seleccionado de btn
    $("#btnEfectivo").click(function() {
      sessionStorage.setItem("Mepa_Metodo", "1")
      $("#btnEfectivo").removeClass("btn-secondary")
      $("#btnEfectivo").addClass("btn-primary")

      $("#btnTarjeta").removeClass("btn-primary")
      $("#btnTarjeta").addClass("btn-secondary")

      $("#btnTransferencias").removeClass("btn-primary")
      $("#btnTransferencias").addClass("btn-secondary")
    })

    $("#btnTarjeta").click(function() {
      sessionStorage.setItem("Mepa_Metodo", "4")
      $("#btnTarjeta").removeClass("btn-secondary")
      $("#btnTarjeta").addClass("btn-primary")

      $("#btnEfectivo").removeClass("btn-primary")
      $("#btnEfectivo").addClass("btn-secondary")

      $("#btnTransferencias").removeClass("btn-primary")
      $("#btnTransferencias").addClass("btn-secondary")
    })

    $("#btnTransferencias").click(function() {
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
        sessionStorage.setItem("Cantidad", "1")
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
              if (data.data[0].Categoria != "Reparaciones") {
                var marca = data.data[0];
                var valor = "1"
                if (data.data[0].Categoria == "Joyas") {
                  valor = 1;
                } else {
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
             
                  }
                });
              } else {

                var data = JSON.parse(response);
                console.log(data);
                sessionStorage.setItem("Diferenciador", "3")
                sessionStorage.setItem("Codigo", data.data[0].Codigo)
                console.log("el codigo es" + data.data[0].Codigo)

                $("#ModalReparacion").modal("show");
                $("#DescripcionRepa").val(null)
                $("#PrecioRepa").val(null)

              }









            } else {

            }

          },
          error: function(error) {
            console.error('Error:', error);
          }
        });
        // Puedes agregar aquí cualquier otra acción que desees ejecutar
      }
    });


    $('#btnSeleccionarProducto').click(function() {
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
      "lengthChange": false, 
     // Deshabilita la opción de cambiar el número de filas por página
      "columns": [{
          "data": "Categoria"
        },
        {
          "data": "Codigo"
        },
        {
          "data": "Producto"
        },
        {
          "data": "PrecioVenta"
        },
        {
          "data": "Stock"
        },
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
        "data": function(d) {
          d.action = 'listarproductos_Factura';
          d.fact_Id = sessionStorage.getItem("Fact_Id");
          d.mayorista = sessionStorage.getItem("Mayorista");
        },
        "dataSrc": function(json) {
          console.log("los datos son:")
          console.log(json.data)
          sessionStorage.setItem("Productos", JSON.stringify(json.data));
          $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
              action: 'listarFacturaId',
              "FactId": sessionStorage.getItem("Fact_Id")
            },
            success: function(response) {
              console.log("SI TRAE EL ENCABEZADO")

              data = JSON.parse(response)
              sessionStorage.setItem("Encabezado", JSON.stringify(data));

              console.log(data)
              console.log("EL IMPUESTO ES" + data.data[0].Fact_Impuesto)
              var subtotal = 0;
              var total = 0;
              var tax = parseFloat(data.data[0].Fact_Impuesto) / 100;

              json.data.forEach(function(item) {
                var itemTotal = parseFloat(item.Total);
                subtotal += itemTotal;
              });

              var taxAmount = subtotal * tax;
              total = subtotal + taxAmount;
              sessionStorage.setItem("Total", total)
              sessionStorage.setItem("SubTotal", subtotal)
              sessionStorage.setItem("taxAmount", taxAmount)

              console.log("El Total es:" + total)
              $("#txtTotal").text(total)
              $("#txtTotal2").text("Total: " + total)
              $("#txtSubtotal").text("Subtotal: " + subtotal)
              $("#txtImpuesto").text("Impuesto: " + taxAmount)
            }

          });
          console.log(json.data);
          return json.data;
        }
      },
      "pageLength": 5,
      "lengthChange": false,
      "columns": [{
          "data": "Categoria"
        },
        {
          "data": "Prod_Codigo"
        },
        {
          "data": "Producto"
        },
        {
          "data": "Precio_Unitario"
        },
        {
          "data": "Cantidad",
          "render": function(data, type, row) {
            var disabled = row.Categoria === "Reparaciones" ? 'disabled' : '';
            return '<form class="cantidad-form" id="form_cantidad_' + row.Prod_Codigo + '"><input type="number" name="cantidad_' + row.Prod_Codigo + '" class="form-control cantidad-input" value="' + data + '" ' + disabled + ' /></form>';
          }
        },
        {
          "data": "Total"
        },
        {
          "data": null,
          "defaultContent": "<div class='text-center'><a class='btn btn-danger btn-sm eliminar-item' style='border-radius: 20px;'><i class='fas fa-trash'></i></a></div>"

        }
      ],
      "dom": 'rt<"bottom"p><"clear">' // Excluye el buscador
    });



    $('#tablaProductos tbody').on('click', '.añadir-item', function() {
      var data = table.row($(this).parents('tr')).data();
      console.log(data);
      sessionStorage.setItem("Cantidad", "1")
      if (data.Categoria == "Joyas" || data.Categoria == "Maquillajes") {
        var valor = "1"
        if (data.Categoria == "Joyas") {
          valor = 1;
        } else {
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
      
          }
        });


      } else {
        sessionStorage.setItem("Diferenciador", "3")
        sessionStorage.setItem("Codigo", data.Codigo)
        $("#ModalListaProductos").modal("hide")
        $("#ModalReparacion").modal("show");
        $("#DescripcionRepa").val(null)
        $("#PrecioRepa").val(null)
      }










    });


    $("#btnConfirmar").click(function() {
      if (sessionStorage.getItem("Mepa_Metodo") == "1") {
        $("#ModalConfirmar").modal("show");
      } else if (sessionStorage.getItem("Mepa_Metodo") == "7") {
        $("#ModalTransferencias").modal("show")

      } else {

        $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'confirmar',
            Fact_Codigo: sessionStorage.getItem("Fact_Id"),
            Fact_FechaFinalizado: new Date().toISOString().slice(0, 19).replace('T', ' '),
            Fact_Pago: sessionStorage.getItem("Total"),
            Fact_Cambio: sessionStorage.getItem("Total"),
            Tarj_Id: "3",
            Tarj_Codigo: "Tarjeta",
            Fact_Total: sessionStorage.getItem("Total")
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


              PdfFactura();
              resetForm();

            } else {
     
            }
          },
          error: function() {
   
          }
        });
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
    $("#confirmarReparacion").click(function() {
      console.log($("#DescripcionRepa").val())
      console.log($("#PrecioRepa").val())
      if ($('#FormReparacion').valid()) {
        $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'insertarreparacion',
            Clie_Id: sessionStorage.getItem("Clie_Id"),
            Mepa_Id: sessionStorage.getItem("Mepa_Metodo"),
            Fact_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
            Fact_FechaModificacion: new Date().toISOString().slice(0, 19).replace('T', ' '),
            Fact_Codigo: sessionStorage.getItem("Fact_Id"),
            Faxd_Diferenciador: sessionStorage.getItem("Diferenciador"),
            Prod_Codigo: sessionStorage.getItem("Codigo"),
            FaxD_Producto: $("#DescripcionRepa").val(),
            FaxD_Precio: $("#PrecioRepa").val()
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
              $("#DescripcionRepa").val(null),
                $("#PrecioRepa").val(null)
              $("#ModalReparacion").modal("hide");
              $('#TablaProductos_Factura').DataTable().ajax.reload();
              $('#tablaProductos').DataTable().ajax.reload();

            } else {
              iziToast.error({
                title: 'Error',
                message: 'No se pudo',
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX'


              });
            }
          },
          error: function() {

          }
        });



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
          } else {
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
  
            }
          });

        } else {
          $input.focus(); // Mantener el foco en el input
        }
      }
    });
    $('#TablaProductos_Factura tbody').on('click', '.eliminar-item', function() {
      var data = tableProductos.row($(this).parents('tr')).data();
      console.log(data.Producto);
      if (data.Categoria != "Reparaciones") {
        $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'eliminarDetalle',
            'Fact_Codigo': sessionStorage.getItem("Fact_Id"),
            'Sucu_Codigo': 1,
            'Prod_Nombre_Codigo': data.Producto
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
    
          }
        });

      } else {

        console.log(data.FaxD_Id);
        $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'eliminarDetalleReparaciones',
            'FaxD_Codigo': data.FaxD_Id,
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
   
          }
        });
      }
    });

    function resetForm() {
      sessionStorage.setItem("Mepa_Metodo", "1");
      $("#btnEfectivo").removeClass("btn-secondary").addClass("btn-primary");
      $("#btnTarjeta").removeClass("btn-primary").addClass("btn-secondary");
      $("#btnTransferencias").removeClass("btn-primary").addClass("btn-secondary");

      $("#tags").val(null);
      $("#auto").val(null);
      sessionStorage.setItem("Fact_Id", "0");
      sessionStorage.setItem("Cantidad", "1");
      sessionStorage.setItem("Clie_Id", "1");
      sessionStorage.setItem("Mayorista", "0");
      sessionStorage.setItem("Total", "0");

      $('#TablaProductos_Factura').DataTable().ajax.reload();
      $('#tablaProductos').DataTable().ajax.reload();

      $("#txtTotal").text("00.0");
      $("#txtTotal2").text("Total: 00.0");
      $("#txtSubtotal").text("Subtotal: 00.0");
      $("#txtImpuesto").text("Impuesto: 00.0");
    }
    $("#btnNuevo").click(function() {
      resetForm();
    })

    $('#Form_Efectivo').validate({
      rules: {
        MontoEfectivo: {
          required: true
        }
      },
      messages: {
        MontoEfectivo: {
          required: "Por favor ingrese un monto"
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

    $('#MontoEfectivo').on('input', function() {
      let montoEfectivo = parseFloat($(this).val()) || 0;
      let cambio = montoEfectivo - parseFloat(sessionStorage.getItem("Total"));

      $('#Cambio').text(cambio.toFixed(2));
    });
    $("#ConfirmarEfectivo").click(function() {
      if ($('#Form_Efectivo').valid()) {
        if (parseFloat($('#Cambio').text()) > 0) {
          $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
              action: 'confirmar',
              Fact_Codigo: sessionStorage.getItem("Fact_Id"),
              Fact_FechaFinalizado: new Date().toISOString().slice(0, 19).replace('T', ' '),
              Fact_Pago: $("#MontoEfectivo").val(),
              Fact_Cambio: $('#Cambio').text(),
              Tarj_Id: "3",
              Tarj_Codigo: "Efectivo",
              Fact_Total: sessionStorage.getItem("Total")
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

                $('#ModalConfirmar').modal('hide');
                PdfFactura();
                resetForm();

              } else {
     
              }
            },
            error: function() {

            }
          });
        } else {
          iziToast.error({
            title: 'Error',
            message: 'Es menor no puede confirmar',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'
          });
        }


      }
    })


    $('#Tarjeta_Form').validate({
      rules: {
        Tarj_Id: {
          required: true,
          notZero: true
        },
        CodigoTransferencia: {
          required: true,
          notZero: true
        }


      },
      messages: {
        Tarj_Id: {
          required: "Por favor ingrese una tarjeta",
          notZero: "Por favor seleccione una tarjeta válida"
        },
        CodigoTransferencia: {
          required: "Por favor ingrese el codigo de transferencia"
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


    $("#ConfirmarTarjeta").click(function() {
      if ($('#Tarjeta_Form').valid()) {
        $.ajax({
          url: 'Services/FacturaService.php',
          type: 'POST',
          data: {
            action: 'confirmar',
            Fact_Codigo: sessionStorage.getItem("Fact_Id"),
            Fact_FechaFinalizado: new Date().toISOString().slice(0, 19).replace('T', ' '),
            Fact_Pago: sessionStorage.getItem("Total"),
            Fact_Cambio: sessionStorage.getItem("Total"),
            Tarj_Id: $("#Tarj_Id").val(),
            Tarj_Codigo: $("#CodigoTransferencia").val(),
            Fact_Total: sessionStorage.getItem("Total")
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

              $('#ModalTransferencias').modal('hide');
              PdfFactura();
              resetForm();

            } else {
   
            }
          },
          error: function() {
     
          }
        });
      } else {
        iziToast.error({
          title: 'Error',
          message: 'No se pudo subir',
          position: 'topRight',
          transitionIn: 'flipInX',
          transitionOut: 'flipOutX'
        });
      }
    })

    $("#btnCancelar").click(function() {
      // Redirigir a la página facturas
      window.location.href = 'facturas';


    });

    function PdfFacturaNumero() {
      var doc = new jsPDF({
        orientation: 'portrait',
        unit: 'px',
        format: [160, 800] // 100px wide and 600px tall
      });
      var cuerpo = JSON.parse(sessionStorage.getItem("Productos"));
      var Encabezado = JSON.parse(sessionStorage.getItem("Encabezado"));
      console.log(Encabezado)

      doc.setFontSize(12);
      doc.setFont(undefined, 'normal');
      doc.text('Esmeraldas HN', 60, 20, {
        align: 'center'
      });
      doc.setFontSize(10);
      doc.setFont(undefined, 'normal');
      doc.text("Francisco Morazan, Tegucigalpa", 60, 30, {
        align: 'center'
      });
      doc.text("Los dolores, calle buenos aires", 60, 40, {
        align: 'center'
      });
      doc.setFontSize(9);
      doc.text("email: esmeraldashn2014@gmail.com", 60, 50, {
        align: 'center'
      });

      doc.setFontSize(12);
      doc.setFont(undefined, 'bold');
      doc.text("Factura:", 53, 70, {
        align: 'center'
      });

      doc.setFontSize(10);
      doc.setFont(undefined, 'normal');
      doc.text("Fecha: " + new Date().toISOString().slice(0, 10).replace('T', ' ') + "   Hora: " + new Date().toISOString().slice(11, 16).replace('T', ' '), 5, 80, {
        align: 'left'
      });
      doc.text("" + Encabezado.data[0].Fact_Id, 77, 70, {
        align: 'center'
      });
      doc.text("Cliente: " + Encabezado.data[0].Clie_Nombre, 5, 90, {
        align: 'left'
      });
      doc.text("RTN: " + Encabezado.data[0].Clie_DNI, 5, 100, {
        align: 'left'
      });
      doc.text("-------------------------------------------", 5, 110, {
        align: 'left'
      });
      doc.setFontSize(8);
      doc.text("  Descripción     Cantidad           Precio ", 5, 120, {
        align: 'left'
      });
      doc.setFontSize(10);
      doc.text("-------------------------------------------", 5, 130, {
        align: 'left'
      });
      const tableData = cuerpo.map(item => [item.Producto, item.Cantidad, item.Precio_Unitario]);
      const yPosition = 130; // Ajustar esta posición para que la tabla inicie justo debajo de la cabecera
      doc.autoTable({
        body: tableData,
        startY: yPosition,
        margin: {
          left: 5
        },
        styles: {
          fontSize: 8,
          fillColor: [255, 255, 255], // Fondo blanco
          textColor: [0, 0, 0] // Texto negro
        },
        headStyles: {
          halign: 'center',
          valign: 'middle',
          fontStyle: 'normal',
          fillColor: [255, 255, 255], // Fondo blanco
          textColor: [0, 0, 0] // Texto negro
        },
        columnStyles: {
          0: {
            halign: 'left',
            cellWidth: 47
          }, // Ancho personalizado para la columna 0
          1: {
            halign: 'center',
            cellWidth: 20
          }, // Ancho personalizado para la columna 1
          2: {
            halign: 'center',
            cellWidth: 60
          } // Ancho personalizado para la columna 2
        },
        theme: 'plain' // Sin líneas de borde, solo blanco
      });
      var total = parseFloat(sessionStorage.getItem("Total"))
      var Impuesto = parseFloat(sessionStorage.getItem("taxAmount"))
      var subtotal = parseFloat(sessionStorage.getItem("SubTotal"))
      const borderYPosition = (doc).previousAutoTable.finalY + 10;
      doc.text("-------------------------------------------", 5, borderYPosition, {
        align: 'left'
      });
      doc.setFontSize(12);
      doc.text("Subtotal", 5, borderYPosition + 10, {
        align: 'left'
      });
      doc.text("Impuesto", 5, borderYPosition + 25, {
        align: 'left'
      });
      doc.text("Total", 5, borderYPosition + 40, {
        align: 'left'
      });
      doc.text(total.toFixed(2).toString(), 110, borderYPosition + 10, {
        align: 'right'
      });
      doc.text(Impuesto.toFixed(2).toString(), 110, borderYPosition + 25, {
        align: 'right'
      });
      doc.text(total.toFixed(2).toString(), 110, borderYPosition + 40, {
        align: 'right'
      });

      doc.setFontSize(10);
      doc.text("-------------------------------------------", 5, borderYPosition + 50, {
        align: 'left'
      });
      doc.setFontSize(14);
      doc.text("Gracias por su compra", 60, borderYPosition + 60, {
        align: 'center'
      });
      console.log("EL LARGO ES DEL COSO" + borderYPosition + 70)
      return borderYPosition + 70;
    }

    function PdfFactura() {
      var largo = PdfFacturaNumero();

      console.log("EL LARGO ES" + largo)
      var doc = new jsPDF({
        orientation: 'portrait',
        unit: 'px',
        format: [160, largo + 80] // 100px wide and 600px tall
      });
      var cuerpo = JSON.parse(sessionStorage.getItem("Productos"));
      var Encabezado = JSON.parse(sessionStorage.getItem("Encabezado"));
      console.log(Encabezado)
      var img = new Image();
      img.src = 'Views/Logo.png';



      doc.addImage(img, 'PNG', 10, 5, 100, 20);

      doc.setFontSize(10);
      doc.setFont(undefined, 'normal');
      doc.text("Francisco Morazan, Tegucigalpa", 60, 30, {
        align: 'center'
      });
      doc.text("Los dolores, calle buenos aires", 60, 40, {
        align: 'center'
      });
      doc.setFontSize(9);
      doc.text("email: esmeraldashn2014@gmail.com", 60, 50, {
        align: 'center'
      });

      doc.setFontSize(12);
      doc.setFont(undefined, 'bold');
      doc.text("Factura:", 53, 70, {
        align: 'center'
      });

      doc.setFontSize(10);
      doc.setFont(undefined, 'normal');
      doc.text("Fecha: " + new Date().toISOString().slice(0, 10).replace('T', ' ') + "   Hora: " + new Date().toISOString().slice(11, 16).replace('T', ' '), 5, 80, {
        align: 'left'
      });
      doc.text("" + Encabezado.data[0].Fact_Id, 77, 70, {
        align: 'center'
      });
      doc.text("Cliente: " + Encabezado.data[0].Clie_Nombre, 5, 90, {
        align: 'left'
      });
      doc.text("RTN: " + Encabezado.data[0].Clie_DNI, 5, 100, {
        align: 'left'
      });
      doc.text("-------------------------------------------", 5, 110, {
        align: 'left'
      });
      doc.setFontSize(8);
      doc.text("  Descripción     Cantidad           Precio ", 5, 120, {
        align: 'left'
      });
      doc.setFontSize(10);
      doc.text("-------------------------------------------", 5, 130, {
        align: 'left'
      });
      const tableData = cuerpo.map(item => [item.Producto, item.Cantidad, item.Precio_Unitario]);
      const yPosition = 130; // Ajustar esta posición para que la tabla inicie justo debajo de la cabecera
      doc.autoTable({
        body: tableData,
        startY: yPosition,
        margin: {
          left: 5
        },
        styles: {
          fontSize: 8,
          fillColor: [255, 255, 255], // Fondo blanco
          textColor: [0, 0, 0] // Texto negro
        },
        headStyles: {
          halign: 'center',
          valign: 'middle',
          fontStyle: 'normal',
          fillColor: [255, 255, 255], // Fondo blanco
          textColor: [0, 0, 0] // Texto negro
        },
        columnStyles: {
          0: {
            halign: 'left',
            cellWidth: 47
          }, // Ancho personalizado para la columna 0
          1: {
            halign: 'center',
            cellWidth: 20
          }, // Ancho personalizado para la columna 1
          2: {
            halign: 'center',
            cellWidth: 60
          } // Ancho personalizado para la columna 2
        },
        theme: 'plain' // Sin líneas de borde, solo blanco
      });
      var total = parseFloat(sessionStorage.getItem("Total"))
      var Impuesto = parseFloat(sessionStorage.getItem("taxAmount"))
      var subtotal = parseFloat(sessionStorage.getItem("SubTotal"))
      const borderYPosition = (doc).previousAutoTable.finalY + 10;
      doc.text("-------------------------------------------", 5, borderYPosition, {
        align: 'left'
      });
      doc.setFontSize(12);
      doc.text("Subtotal", 5, borderYPosition + 10, {
        align: 'left'
      });
      doc.text("Impuesto", 5, borderYPosition + 25, {
        align: 'left'
      });
      doc.text("Total", 5, borderYPosition + 40, {
        align: 'left'
      });
      doc.text(total.toFixed(2).toString(), 110, borderYPosition + 10, {
        align: 'right'
      });
      doc.text(Impuesto.toFixed(2).toString(), 110, borderYPosition + 25, {
        align: 'right'
      });
      doc.text(total.toFixed(2).toString(), 110, borderYPosition + 40, {
        align: 'right'
      });

      doc.setFontSize(10);
      doc.text("-------------------------------------------", 5, borderYPosition + 50, {
        align: 'left'
      });
      doc.setFontSize(14);
      doc.text("Gracias por su compra", 60, borderYPosition + 60, {
        align: 'center'
      });
      console.log(borderYPosition + 70)





      // Generar PDF como blob
      const pdfBlob = doc.output('blob');
      const url = URL.createObjectURL(pdfBlob);
      const iframe = document.getElementById('pdf-frame');
      iframe.src = url;

      iframe.onload = function() {
        iframe.contentWindow.print();
      };
    }


  });
</script>