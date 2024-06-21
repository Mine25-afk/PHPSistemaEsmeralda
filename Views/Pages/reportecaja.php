<style>
   
        .Mostrar {
            width: 100%;
            height: 100vh; /* Adjust the height to 100% of the viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #pdf-frame2 {
            width: 100%;
            height: 100%;
            border: none; /* Optional: remove border */
        }
</style>

<div class="card">
  <div class="card-body">
    <h2 class="text-center" style="font-size: 90px !important">Reporte caja</h2>
    <div class="form-row">
            <div class="col-md-6">
            <input type="date" class="form-control" id="reservationdate" name="reservationdate">
            </div>

            <div class="col-md-6">
            <select id="Sucursal" name="Sucursal" class="form-control" style="width: 100%;">
            <option selected="selected" value="0">--Seleccione--</option>
            </select>
            </div>
  </div>
    
   

  
    <iframe id="pdf-frame2"></iframe>
    <!-- Cierre de CrearMostrar -->
  </div>
  <!-- Cierre de card-body -->
</div>
<script>
            $(document).ready(function() {
            // Obtener el valor de Sucu_Id desde PHP
            var sucuIdPredeterminado = "<?php echo $_SESSION['Sucu_Id']; ?>";

            // Configurar la fecha y hora predeterminadas
            var now = new Date();
            var formattedDate = now.toISOString().slice(0,10); // Get the format yyyy-MM-dd
            $('#reservationdate').val(formattedDate);

            $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'totalesSucu',
                FechaHoy: new Date().toISOString().slice(0, 11).replace('T', ' '),
                Sucu_Id: sucuIdPredeterminado
            },
            success: function(response) {
                console.log(response)
                data = JSON.parse(response)
                console.log(data);

               $("#txtVentasEfectivo").val(data.data[0].Efectivo + " .Lps")
               $("#txtVentasTransferencias").val(data.data[0].Transferencias + " .Lps")
               $("#txtVentasCredito").val(data.data[0].Tarjeta_Credito + " .Lps")
               $("#txtRetiros").val(data.data[0].TotalRetiro + " .Lps")
               $("#txtDiferencia").text("0.00" + " .Lps")
               $("#txtMontoInicial").text(data.data[0].MontoInicial + " .Lps")
                const totalEfectivo = (parseFloat(data.data[0].MontoInicial) + parseFloat(data.data[0].Efectivo)) - parseFloat(data.data[0].TotalRetiro)
               $("#txtTotalEfectivo").val(totalEfectivo.toFixed(2) + " .Lps")
               
               sessionStorage.setItem("TotalEfectivo", totalEfectivo.toFixed(2).toString())
               sessionStorage.setItem("Caja_Id", data.data[0].Caja_Id)
               sessionStorage.setItem("MontoInicial", data.data[0].MontoInicial)
        


            
               
            },
            error: function() {
                alert('Error en la comunicación con el servidor.');
            }
        });

        $('#reservationdate, #Sucursal').change(function() {
                console.log($("#reservationdate").val())
                console.log($("#Sucursal").val())
            
            });

            // Realizar la llamada AJAX para obtener las sucursales
            $.ajax({
                url: 'Services/FacturaCompraService.php',
                type: 'POST',
                data: {
                    action: 'listarSucursales'
                },
                success: function(response) {
                    var sucursales = JSON.parse(response);
                    console.log(sucursales);
                    var sucuseleccionada = $('#Sucursal');
                    sucuseleccionada.empty().append('<option value="0">--Seleccione--</option>');
                    sucursales.forEach(function(sucursal) {
                        var selected = sucursal.Sucu_Id == sucuIdPredeterminado ? ' selected' : '';
                        sucuseleccionada.append('<option value="' + sucursal.Sucu_Id + '"' + selected + '>' + sucursal.Sucu_Nombre + '</option>');
                    });
                }
            });
        });
    </script>



   
   