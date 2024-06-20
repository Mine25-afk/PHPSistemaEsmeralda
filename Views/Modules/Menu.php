<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="Views/Resources/index3.html" class="brand-link">
      <img src="Views/Resources/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema Esmeralda</span>
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
        <img src="Views/Resources/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
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

  <div class="modal fade" id="AbrirCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Deseas abrir la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="CajaForm" enctype="multipart/form-data">




    <div class="form-row">
    <div class="col-md-6">
        <label class="control-label">Monto Inicial</label>
        <input name="Inicial" class="form-control letras" id="Inicial"/>
        <span class="text-danger"></span>
        </div>


    
    </div>





    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="guardarBtnCaja">Abrir</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="CerrarCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Deseas cerrar la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="CerrarCajaForm" enctype="multipart/form-data">




    <div class="form-row">
        <div class="col-md-6">
        <label class="control-label">Monto Final</label>
        <input name="Final" class="form-control letras" id="Final"/>
        <span class="text-danger"></span>
        </div>

        <div class="col-md-6">
        <label class="control-label">Observaciones</label>
        <input name="Observaciones" class="form-control letras" id="Observaciones"/>
        <span class="text-danger"></span>
        </div>

    
    </div>





    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="CerrarBtnCaja">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="RetiroCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Deseas cerrar la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="RetiroCajaForm" enctype="multipart/form-data">




    <div class="form-row">
        <div class="col-md-6">
        <label class="control-label">Efectivo a retirar</label>
        <input name="Efectivo" class="form-control letras" id="Efectivo"/>
        <span class="text-danger"></span>
        </div>

        <div class="col-md-6">
        <label class="control-label">Observaciones</label>
        <input name="ObservacionesRe" class="form-control letras" id="ObservacionesRe"/>
        <span class="text-danger"></span>
        </div>

    
    </div>





    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="RetirarBtnCaja">Retirar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
      $('#AbrirCajas').click(function() {
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
                alert('Error en la comunicación con el servidor.');
            }
        });
  }
  });


  $('#CerrarCajas').click(function() {
        $('#CerrarCajaModal').modal('show');
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
                caja_MontoInicial: $("#Final").val(), 
                caja_MontoFinal: $("#Final").val(), 
                caja_MontoSistema:$("#Final").val(), 
                caja_Observacion: $("#Observaciones").val(),
                caja_codigo: 1,
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
                alert('Error en la comunicación con el servidor.');
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
                alert('Error en la comunicación con el servidor.');
            }
        });
  }
  });
    });
</script> 