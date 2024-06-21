<style>
      #pdf-frame {
            display: none; /* Ocultar el iframe */
        }
</style>
<script>
  $(document).ready(function() {
    var availableTags = [{
        label: "061120050073 - 1",
        value: "061120050073"
      },
      {
        label: "0711 - 2",
        value: "0711"
      },
      {
        label: "60 - 3",
        value: "60"
      },
      // ... otros datos ...
      {
        label: "DNI_Random_1 - ID_Random_1",
        value: "DNI_Random_1"
      },
      {
        label: "DNI_Random_2 - ID_Random_2",
        value: "DNI_Random_2"
      },
      // ... más datos aleatorios ...
    ];
    $("#tags").autocomplete({
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
  });
</script>
<div class="card">
  <div class="card-body">
    <h2 class="text-center" style="font-size: 90px !important">Facturas</h2>

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
              <input name="Pago" class="form-control letras" id="Pago" />
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
                  <input name="MontoEfectivo" class="form-control letras" id="MontoEfectivo"/>
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
                  <input name="CodigoTransferencia" class="form-control letras" id="CodigoTransferencia"/>
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

<iframe id="pdf-frame"></iframe>
<script>
  $(document).ready(function() {
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
      "columns": [{
          "data": "Fact_Id"
        },
        {
          "data": "Clie_Nombre"
        },
        {
          "data": "Mepa_Metodo"
        },
        {
          "data": "Acciones"
        },
      ]
    });

    $('#tablaFactura tbody').on('click', '.abrir-confirmar', function() {
      var data = table.row($(this).parents('tr')).data();
      var Fact_Id = data.Fact_Id;

      console.log(data.Clie_EsMayorista)
      sessionStorage.setItem('Fact_Id', Fact_Id);
      sessionStorage.setItem("Clie_DNI", data.Clie_DNI)
              sessionStorage.setItem("Clie_Nombre", data.Clie_Nombre)
      sessionStorage.setItem('Mayorista', data.Clie_EsMayorista);
      $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            "data": {
            'action': 'listarproductos_Factura',
            'fact_Id' : sessionStorage.getItem("Fact_Id"),
            'mayorista' :sessionStorage.getItem("Mayorista"),
            },
            success: function(response) {
          
              console.log("los datos son:")
              datos = JSON.parse(response)
              console.log(datos)
           
              var subtotal = 0;
              var total = 0;
              console.log(data.Fact_Impuesto)
              var tax = parseFloat(data.Fact_Impuesto) / 100;
              
              sessionStorage.getItem("Mayorista")

              datos.data.forEach(function(item) {
                var itemTotal = parseFloat(item.Total);
                subtotal += itemTotal;
            })
            var taxAmount = subtotal * tax;
            total = subtotal + taxAmount;
            sessionStorage.setItem("Total",total)
            sessionStorage.setItem("SubTotal", subtotal)
            sessionStorage.setItem("taxAmount", taxAmount)
            console.log(total)
          }
         
          
          });
      

      if (data.Mepa_Metodo != "Efectivo") {
        $("#ModalTransferencias").modal("show")
      }else{
        $("#ModalConfirmar").modal("show");
      }
      

    });

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
    $('#MontoEfectivo').on('input', function() {
        let montoEfectivo = parseFloat($(this).val()) || 0;
        let cambio = montoEfectivo -  parseFloat(sessionStorage.getItem("Total"));
        $('#Cambio').text(cambio.toFixed(2));
    });

    $("#ConfirmarEfectivo").click(function () {
      if ($('#Form_Efectivo').valid()) {
          if (parseFloat($('#Cambio').text()) > 0)  {
            $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'confirmar',
                Fact_Codigo: sessionStorage.getItem("Fact_Id"),
                Fact_FechaFinalizado:  new Date().toISOString().slice(0, 19).replace('T', ' '),
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
                    $.ajax({
    url: 'Services/FacturaService.php',
    type: 'POST',
    data: {
        'action': 'listarproductos_Factura',
        'fact_Id': sessionStorage.getItem("Fact_Id"),
        'mayorista': sessionStorage.getItem("Mayorista"),
    },
        success: function(json) {
        data = json
        sessionStorage.setItem("ProductosFactura", JSON.stringify(data));



        $("#tablaFactura").DataTable().ajax.reload();
        $('#ModalConfirmar').modal('hide');
        PdfFactura();
      
    }
                   
  });

                    


         
                 
                  
                } else {
                    alert('Error al eliminar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
          }else{
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


    $("#ConfirmarTarjeta").click(function(){
      if ($('#Tarjeta_Form').valid()) {
        $.ajax({
            url: 'Services/FacturaService.php',
            type: 'POST',
            data: {
                action: 'confirmar',
                Fact_Codigo: sessionStorage.getItem("Fact_Id"),
                Fact_FechaFinalizado:  new Date().toISOString().slice(0, 19).replace('T', ' '),
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
                   
                    

                    $.ajax({
    url: 'Services/FacturaService.php',
    type: 'POST',
    data: {
        'action': 'listarproductos_Factura',
        'fact_Id': sessionStorage.getItem("Fact_Id"),
        'mayorista': sessionStorage.getItem("Mayorista"),
    },
        success: function(json) {
        console.log("Los datos son:");
        console.log(json.data);
        sessionStorage.setItem("ProductosFactura", JSON.stringify(json.data));

      
        
    }
  });



                    $('#ModalTransferencias').modal('hide');
                    PdfFactura();
            
                  
                } else {
                    alert('Error al eliminar joya.');
                }
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });
          }else{
            iziToast.error({
            title: 'Error',
            message: 'No se pudo subir',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'
        });
      }
    })


    $('#tablaFactura tbody').on('click', '.abrir-editar', function() {
      var data = table.row($(this).parents('tr')).data();
      var Fact_Id = data.Fact_Id;
      sessionStorage.setItem('Fact_Id', Fact_Id);
      sessionStorage.setItem("CrearOEditar","Editar")
      window.location.href = 'index.php?Pages=FacturaVenta';

    });

 
    

  

  

    


  








    $('#tablaFactura tbody').on('click', '.abrir-detalles', function() {
      console.log("HOLA")
      var doc = new jsPDF();
      doc.text('Hola, este es un PDF generado desde JavaScript con JsPdf', 10, 10);
      doc.save('archivo.pdf');
    });





    $('#AbrirModal').click(function() {
      sessionStorage.setItem("CrearOEditar","Crear")
      window.location.href = 'index.php?Pages=FacturaVenta';
    });


    function PdfFacturaNumero() {
      
   

      var doc = new jsPDF({
    orientation: 'portrait',
    unit: 'px',
    format: [190,400]  // 100px wide and 600px tall
    });

var img = new Image();
img.src = 'Views/Logo.png';

var cuerpo = JSON.parse(sessionStorage.getItem("ProductosFactura"));
    
var data  = JSON.parse(cuerpo)
console.log("MAPEADO A")
console.log(data.data)

doc.addImage(img, 'PNG', 10, 5, 100, 20);

doc.setFontSize(10);
doc.setFont(undefined, 'normal');
doc.text("Francisco Morazan, Tegucigalpa", 60, 30, { align: 'center' });
doc.text("Los dolores, calle buenos aires", 60, 40, { align: 'center' });
doc.setFontSize(9);
doc.text("email: esmeraldashn2014@gmail.com", 60, 50, { align: 'center' });

  doc.setFontSize(12);
  doc.setFont(undefined, 'bold');
  doc.text("Factura:", 53, 70, { align: 'center' });

  doc.setFontSize(10);
  doc.setFont(undefined, 'normal');
  doc.text("Fecha: " + new Date().toISOString().slice(0, 10).replace('T', ' ') + "   Hora: " + new Date().toISOString().slice(11, 16).replace('T', ' ') , 5, 80, { align: 'left' });
  doc.text(sessionStorage.getItem("Fact_Id") , 77, 70, { align: 'center' });
  doc.text("Cliente: " + sessionStorage.getItem("Clie_Nombre") ,  5, 90, { align: 'left' });
  doc.text("RTN: "+ sessionStorage.getItem("Clie_DNI"),  5, 100, { align: 'left' });
  doc.text("-------------------------------------------", 5, 110, { align: 'left' });
  doc.setFontSize(8);
  doc.text("  Descripción     Cantidad           Precio ", 5, 120, { align: 'left' });
  doc.setFontSize(10);
  doc.text("-------------------------------------------", 5, 130, { align: 'left' });
  const tableData = data.data.map(item => [item.Producto, item.Cantidad, item.Precio_Unitario]);
  const yPosition = 130; // Ajustar esta posición para que la tabla inicie justo debajo de la cabecera
  doc.autoTable({
    body: tableData,
    startY: yPosition,
    margin: { left: 5},
    styles: {
      fontSize: 8,
      fillColor: [255, 255, 255], // Fondo blanco
      textColor: [0, 0, 0]       // Texto negro
    },
    headStyles: {
      halign: 'center',
      valign: 'middle',
      fontStyle: 'normal',
      fillColor: [255, 255, 255], // Fondo blanco
      textColor: [0, 0, 0]       // Texto negro
    },
    columnStyles: {
      0: { halign: 'left', cellWidth: 47 },  // Ancho personalizado para la columna 0
      1: { halign: 'center', cellWidth: 20 },  // Ancho personalizado para la columna 1
      2: { halign: 'center', cellWidth: 60 }   // Ancho personalizado para la columna 2
    },
    theme: 'plain' // Sin líneas de borde, solo blanco
  });
  var total = parseFloat(sessionStorage.getItem("Total"))
  var Impuesto = parseFloat(sessionStorage.getItem("taxAmount"))
  var subtotal = parseFloat(sessionStorage.getItem("SubTotal"))
  const borderYPosition = (doc).previousAutoTable.finalY + 10;
  doc.text("-------------------------------------------", 5, borderYPosition, { align: 'left' });
  doc.setFontSize(12);
  doc.text("Subtotal", 5, borderYPosition + 10, { align: 'left' });
  doc.text("Impuesto", 5, borderYPosition + 25, { align: 'left' });
  doc.text("Total", 5, borderYPosition + 40 , { align: 'left' });
  doc.text(total.toFixed(2).toString(), 110, borderYPosition + 10, { align: 'right' });
  doc.text(Impuesto.toFixed(2).toString(), 110, borderYPosition + 25, { align: 'right' });
  doc.text(total.toFixed(2).toString(), 110, borderYPosition + 40, { align: 'right' });

  doc.setFontSize(10);
  doc.text("-------------------------------------------", 5, borderYPosition + 50, { align: 'left' });
doc.setFontSize(14);
doc.text("Gracias por su compra", 60, borderYPosition + 60 , { align: 'center' });
console.log(borderYPosition + 70)
return borderYPosition + 70
            }
   
    function PdfFactura() {
      
      var largo = PdfFacturaNumero()

      var doc = new jsPDF({
    orientation: 'portrait',
    unit: 'px',
    format: [160,largo + 90]  // 100px wide and 600px tall
    });

var img = new Image();
img.src = 'Views/Logo.png';

var cuerpo = JSON.parse(sessionStorage.getItem("ProductosFactura"));
    
var data  = JSON.parse(cuerpo)
console.log("MAPEADO A")
console.log(data.data)

doc.addImage(img, 'PNG', 10, 5, 100, 20);

doc.setFontSize(10);
doc.setFont(undefined, 'normal');
doc.text("Francisco Morazan, Tegucigalpa", 60, 30, { align: 'center' });
doc.text("Los dolores, calle buenos aires", 60, 40, { align: 'center' });
doc.setFontSize(9);
doc.text("email: esmeraldashn2014@gmail.com", 60, 50, { align: 'center' });

  doc.setFontSize(12);
  doc.setFont(undefined, 'bold');
  doc.text("Factura:", 53, 70, { align: 'center' });

  doc.setFontSize(10);
  doc.setFont(undefined, 'normal');
  doc.text("Fecha: " + new Date().toISOString().slice(0, 10).replace('T', ' ') + "   Hora: " + new Date().toISOString().slice(11, 16).replace('T', ' ') , 5, 80, { align: 'left' });
  doc.text(sessionStorage.getItem("Fact_Id") , 77, 70, { align: 'center' });
  doc.text("Cliente: " + sessionStorage.getItem("Clie_Nombre") ,  5, 90, { align: 'left' });
  doc.text("RTN: "+ sessionStorage.getItem("Clie_DNI"),  5, 100, { align: 'left' });
  doc.text("-------------------------------------------", 5, 110, { align: 'left' });
  doc.setFontSize(8);
  doc.text("  Descripción     Cantidad           Precio ", 5, 120, { align: 'left' });
  doc.setFontSize(10);
  doc.text("-------------------------------------------", 5, 130, { align: 'left' });
  const tableData = data.data.map(item => [item.Producto, item.Cantidad, item.Precio_Unitario]);
  const yPosition = 130; // Ajustar esta posición para que la tabla inicie justo debajo de la cabecera
  doc.autoTable({
    body: tableData,
    startY: yPosition,
    margin: { left: 5},
    styles: {
      fontSize: 8,
      fillColor: [255, 255, 255], // Fondo blanco
      textColor: [0, 0, 0]       // Texto negro
    },
    headStyles: {
      halign: 'center',
      valign: 'middle',
      fontStyle: 'normal',
      fillColor: [255, 255, 255], // Fondo blanco
      textColor: [0, 0, 0]       // Texto negro
    },
    columnStyles: {
      0: { halign: 'left', cellWidth: 47 },  // Ancho personalizado para la columna 0
      1: { halign: 'center', cellWidth: 20 },  // Ancho personalizado para la columna 1
      2: { halign: 'center', cellWidth: 60 }   // Ancho personalizado para la columna 2
    },
    theme: 'plain' // Sin líneas de borde, solo blanco
  });
  var total = parseFloat(sessionStorage.getItem("Total"))
  var Impuesto = parseFloat(sessionStorage.getItem("taxAmount"))
  var subtotal = parseFloat(sessionStorage.getItem("SubTotal"))
  const borderYPosition = (doc).previousAutoTable.finalY + 10;
  doc.text("-------------------------------------------", 5, borderYPosition, { align: 'left' });
  doc.setFontSize(12);
  doc.text("Subtotal", 5, borderYPosition + 10, { align: 'left' });
  doc.text("Impuesto", 5, borderYPosition + 25, { align: 'left' });
  doc.text("Total", 5, borderYPosition + 40 , { align: 'left' });
  doc.text(total.toFixed(2).toString(), 110, borderYPosition + 10, { align: 'right' });
  doc.text(Impuesto.toFixed(2).toString(), 110, borderYPosition + 25, { align: 'right' });
  doc.text(total.toFixed(2).toString(), 110, borderYPosition + 40, { align: 'right' });

  doc.setFontSize(10);
  doc.text("-------------------------------------------", 5, borderYPosition + 50, { align: 'left' });
doc.setFontSize(14);
doc.text("Gracias por su compra", 60, borderYPosition + 60 , { align: 'center' });
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