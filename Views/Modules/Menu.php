<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=The+Nautigal:wght@400;700&display=swap" rel="stylesheet">
<style>
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, 
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
    background-color: #E1FEE0;
    color: #000000;
}

.brand-link {
    background-color: #000000;
}

.brand-link .brand-text {
    color: #5d9e3e;
}

.form-control-sidebar {
    background-color: #000000;
    border: 1px solid #5d9e3e;
    color: #5d9e3e;
}

.input-group-append .btn-sidebar {
    background-color: #5d9e3e;
    color: #000000;
}

.modal-header {
    background-color: #5d9e3e;
}

.modal-title {
    color: #000000;
}

.btn-primary:hover, .btn-primary, .btn:active {
    background-color: #5d9e3e;
    border-color: #5d9e3e;
    color: #FFFFFF;
    background:#5d9e3e;
    
}




.hover{
  background-color: #5d9e3e;
}

.btn-secondary {
    background-color: #000000;
    border-color: #000000;
    color: #5d9e3e;
}

.nav-item > .nav-treeview {
    display: none;
}

.nav-item.menu-open > .nav-treeview {
    display: block;
}

h2{
  font-family: "The Nautigal", cursive;
  font-weight: 100;
  font-style: normal;
  font-weight: 1000;

}





</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000000;">
    <!-- Brand Logo -->
    <a href="Views/Resources/index3.html" class="brand-link" style="text-align: center;">
     
      <img src="/PHPSistemaEsmeralda/Views/Logo3.png" alt="Logo" style="width: 230px; height: 100;">
    </a>

 

     
    <?php
      if (session_status() == PHP_SESSION_NONE) {
          session_start();
      }
      require_once __DIR__ . '/../../config.php';// Asegúrate de incluir la conexión a la base de datos.
      include 'C:\xampp\htdocs\PHPSistemaEsmeralda\Services\MenuService.php';
      $nombreCompleto = isset($_SESSION['Empl_Nombre']) ? $_SESSION['Empl_Nombre'] : 'Usuario invitado';
    ?>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="/PHPSistemaEsmeralda/Views/xd.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color:white">
            <?php echo htmlspecialchars($nombreCompleto); ?>
          </a>
        </div>
      </div>




      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <?php generarMenu($pdo); ?>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="AbrirCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5d9e3e;">
                <h5 class="modal-title" id="eliminarModalLabel" style="color: #000000;">Deseas abrir la caja?</h5>
               
            </div>
            <div class="modal-body">
        <div class="row">
            <div class="col-md-12 col-sm-8 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                <span class="info-box-text" id="txtFecha">Fecha</span>
                <span class="info-box-text">Usuario:  <?php echo $_SESSION['Usua_Usuario']; ?></span>
                <span class="info-box-text">Sucursal: <?php echo $_SESSION['Sucu_Nombre']; ?></span>
                    </div>
                </div>
            </div>
        </div>
         
         
              

             
              <!-- /.info-box-content -->
         
            <!-- /.info-box -->
          
                <form id="CajaForm" enctype="multipart/form-data">

                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Monto Inicial</label>
                            <input name="Inicial" class="form-control letras" id="Inicial" style="border: 1px solid #5d9e3e;"/>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="SalirCaja">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarBtnCaja">Abrir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="CerrarCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5d9e3e;">
                <h5 class="modal-title" id="eliminarModalLabel" style="color: #000000;">Deseas cerrar la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
            <div class="col-md-4 col-sm-8 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 800;">Fecha Cierre</span>
                <span class="info-box-text" id="txtFechaCierre"></span>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-8 col-12">
                <div class="info-box" style="height: 80px !important;">
                    <span class="info-box-icon bg-info"><i class="far fa-money-bill-alt"></i></span>
                    <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 800;">Diferencia</span>
                <span class="info-box-text"><p id="txtDiferencia"></p></span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-8 col-12">
                <div class="info-box" style="height: 80px !important;">
                    <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                <span class="info-box-text" style="font-weight: 800;">Monto Inicial</span>
                <span class="info-box-text"><p id="txtMontoInicial"></p></span>
                    </div>
                </div>
            </div>
        </div> <form id="CerrarCajaForm" enctype="multipart/form-data">
        <div class="row">

            <div class="col-md-6">
                <div style="text-align: center;">
                    <h2>Ingresos</h1>
                </div>
                <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                        <label for="" >Ventas Efectivo:</label>
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control" id="txtVentasEfectivo" disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                        <label for="" >Ventas en transferencia:</label>
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control" id="txtVentasTransferencias" disabled="true">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" style="text-align:center;">
                        <label for="" >Ventas en tarjeta credito:</label>
                    </div>
                    <div class="col-md-6">
                       <input type="text" class="form-control" id="txtVentasCredito" disabled="true">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div style="text-align: center;">
                    <h2 style="font-size: 30px;">Egresos</h2>
                    <div class="row">
                    <div class="col-md-6" style="text-align: end;">
                        <label for="" >Total Retiros:</label>
                        
                    </div>
                    <div class="col-md-6">
                    <input type="text" class="form-control" id="txtRetiros" disabled="true">
                    </div>
                    </div>
                    <h2 style="font-size: 30px;">Caja</h2>
                    <div class="row">
                    <div class="col-md-6" style="text-align: end;">
                        <label for="" >Total Efectivo:</label>
                        <input type="text" class="form-control" id="txtTotalEfectivo" disabled="true">
                    </div>
                    <div class="col-md-6">
                    <label for="" >Efectivo Final</label>
                    <input type="text" name="Final"  class="form-control" id="Final">
                    </div>
                    </div>
             
                    <div class="row">
                    <div class="col-md-6" style="text-align: end;">
              
                     
                    </div>
                   
                    <div class="col-md-6">
               
                    </div>
                    </div>
                </div>
            </div>
                    <div class="col-md-12" >
                            <label class="control-label">Observaciones</label>
                            <input name="Observaciones" class="form-control letras"  id="Observaciones" style="border: 1px solid #5d9e3e;"/>
                            <span class="text-danger"></span>
                        </div>
                 
        </div>
        </form>
                    
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="CerrarBtnCaja">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="RetiroCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5d9e3e;">
                <h5 class="modal-title" id="eliminarModalLabel" style="color: #000000;">Deseas retirar efectivo?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            <div class="row">
            <div class="col-md-12 col-sm-8 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                <span class="info-box-text" id="txtFechaRetiro">Fecha</span>
                <span class="info-box-text">Usuario:  <?php echo $_SESSION['Usua_Usuario']; ?></span>
                <span class="info-box-text">Sucursal: <?php echo $_SESSION['Sucu_Nombre']; ?></span>
                    </div>
                </div>
            </div>
        </div>
      
                <form id="RetiroCajaForm" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Efectivo a retirar</label>
                            <input name="Efectivo" class="form-control letras" id="Efectivo" style="border: 1px solid #5d9e3e;"/>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Observaciones</label>
                            <input name="ObservacionesRe" class="form-control letras" id="ObservacionesRe"  style="border: 1px solid #5d9e3e;" />
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="RetirarBtnCaja">Retirar</button>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {
        $("#AbrirLink").hide()
        $("#CerrarLink").hide()
        $("#RetiroLink").hide()

        $("#txtFechaCierre").text(  new Date().toISOString().slice(0, 11).replace('T', ' '))
        $("#txtFechaRetiro").text("Fecha: " + new Date().toISOString().slice(0, 11).replace('T', ' '))
        $("#txtFecha").text("Fecha: " + new Date().toISOString().slice(0, 11).replace('T', ' '))
        validar()
        function validar() {
            $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'validacion',
                FechaHoy: new Date().toISOString().slice(0, 11).replace('T', ' ')
            },
            success: function(response) {
                console.log(response)
                if (response == 0) {
                    $("#AbrirLink").show()
                    $("#CerrarLink").hide()
                    $("#RetiroLink").hide()
               
                }else{
                    $("#CerrarLink").show()
                    $("#RetiroLink").show()
                    $("#AbrirLink").hide()
                
                }
      
               
            },
            error: function() {
  
            }
        });
        }
       


      $('#AbrirCajas').click(function() {
        $('#AbrirCajaModal').modal('show');
      });
      $('#SalirCaja').click(function() {
         window.location.href = 'Index';
        $('#AbrirCajaModal').modal('show');
      });
   


      $('#CajaForm').validate({
        rules: {
          Inicial: {
                required: true
            }
        },
        messages: {
          Inicial: {
                required: "Por favor ingrese su monto inicial"
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


    $('#guardarBtnCaja').click(function() {
    if ($('#CajaForm').valid()) {

        $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'insertar',
                caja_MontoInicial: $("#Inicial").val(),
                caja_UsuarioApertura: 1, 
                caja_FechaApertura: new Date().toISOString().slice(0, 19).replace('T', ' ')
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                  $('#AbrirCajaModal').modal('hide');
                  $('#CajaForm').trigger('reset');
                  $('#CajaForm').validate().resetForm();
                  validar()
                    iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


        });

            $('#AbrirCajaModal').hide();
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
    
            }
        });
  }
  });


  $('#CerrarCajas').click(function() {
        $('#CerrarCajaModal').modal('show');
        $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'totales',
                FechaHoy: new Date().toISOString().slice(0, 11).replace('T', ' ')
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
  });

    $('#Final').on('input', function() {
      let montoEfectivo = parseFloat($(this).val()) || 0;
      let cambio =  montoEfectivo - parseFloat(sessionStorage.getItem("TotalEfectivo"));

      $('#txtDiferencia').text(cambio.toFixed(2));
    });

  $('#FacturaLink').click(function() {
       sessionStorage.setItem("CrearOEditar", "Crear")
  });

  $('#CerrarCajaForm').validate({
        rules: {
          Final: {
                required: true
            },
          Observaciones: {
              required: true
          }
        },
        messages: {
          Final: {
                required: "Por favor ingrese su monto final"
            },
          Observaciones: {
              required: "Por favor ingrese una observacion"
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


    $('#CerrarBtnCaja').click(function() {
    if ($('#CerrarCajaForm').valid()) {

        $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'cerrar',
                caja_FechaCierre: new Date().toISOString().slice(0, 19).replace('T', ' '),
                caja_MontoInicial: sessionStorage.getItem("MontoInicial"), 
                caja_MontoFinal: $("#Final").val(), 
                caja_MontoSistema: sessionStorage.getItem("TotalEfectivo"), 
                caja_Observacion: $("#Observaciones").val(),
                caja_codigo: sessionStorage.getItem("Caja_Id")
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                  $('#CerrarCajaModal').modal('hide');
                  $('#CerrarCajaForm').trigger('reset');
                  $('#CerrarCajaForm').validate().resetForm();
                    iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'
           


        });
        
            validar()
  
 
            $('#AbrirCajaModal').hide();
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
      
            }
        });
  }
  });


  $('#AbrirRetiro').click(function() {
        $('#RetiroCajaModal').modal('show');
  });

  $('#RetiroCajaForm').validate({
        rules: {
          Efectivo: {
                required: true
            },
          ObservacionesRe: {
              required: true
          }
        },
        messages: {
          Efectivo: {
                required: "Por favor ingrese el monto a retirar"
            },
            ObservacionesRe: {
              required: "Por favor ingrese una observacion"
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

    
    $('#RetirarBtnCaja').click(function() {
    if ($('#RetiroCajaForm').valid()) {

        $.ajax({
            url: 'Views/Modules/ServicesModules/MenuService.php',
            type: 'POST',
            data: {
                action: 'retiro',
                cadi_Dinero: $("#Efectivo").val(), 
                cadi_Observaciones: $("#ObservacionesRe").val(), 
                FechaHoy: new Date().toISOString().slice(0, 19).replace('T', ' '),
            },
            success: function(response) {
                console.log(response)
                if (response == 1) {
                  $('#RetiroCajaModal').modal('hide');
                  $('#RetiroCajaForm').trigger('reset');
                  $('#RetiroCajaForm').validate().resetForm();
                    iziToast.success({
            title: 'Éxito',
            message: 'Subido con exito',
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX'


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
            },
            error: function() {
        
            }
        });
  }
  });
    });
</script> 


