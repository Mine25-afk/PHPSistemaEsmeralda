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

.btn-primary:hover, .btn-primary {
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
            <div class="modal-header" style="background-color: #5d9e3e;">
                <h5 class="modal-title" id="eliminarModalLabel" style="color: #000000;">Deseas abrir la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="guardarBtnCaja">Abrir</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="CerrarCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5d9e3e;">
                <h5 class="modal-title" id="eliminarModalLabel" style="color: #000000;">Deseas cerrar la caja?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="CerrarCajaForm" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Monto Final</label>
                            <input name="Final" class="form-control letras" id="Final" style="border: 1px solid #5d9e3e;"/>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Observaciones</label>
                            <input name="Observaciones" class="form-control letras" id="Observaciones" style="border: 1px solid #5d9e3e;"/>
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
                <form id="RetiroCajaForm" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label class="control-label">Efectivo a retirar</label>
                            <input name="Efectivo" class="form-control letras" id="Efectivo" style="border: 1px solid #5d9e3e;"/>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Observaciones</label>
                            <input name="ObservacionesRe" class="form-control letras" id="ObservacionesRe" style="border: 1px solid #5d9e3e;"/>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    const menuItems = document.querySelectorAll(".nav-item > .nav-link");

    menuItems.forEach(item => {
        item.addEventListener("click", function(event) {
            event.stopPropagation();

            const parent = item.parentElement;
            const submenu = parent.querySelector(".nav-treeview");

            // Si el menú ya está abierto, simplemente se cierra
            if (parent.classList.contains("menu-open")) {
                parent.classList.remove("menu-open");
            } else {
                // Cierra otros submenús
                document.querySelectorAll(".nav-item").forEach(i => i.classList.remove("menu-open"));
                // Abre el submenú del elemento seleccionado
                parent.classList.add("menu-open");
            }
        });
    });

    // Gestionar enlaces del submenú
    const subMenuLinks = document.querySelectorAll(".nav-treeview .nav-link");

    subMenuLinks.forEach(link => {
        link.addEventListener("click", function() {
            // Mantiene el submenú abierto
            const parent = link.closest(".nav-item");
            document.querySelectorAll(".nav-item").forEach(i => i.classList.remove("menu-open"));
            parent.classList.add("menu-open");
        });
    });
});
</script>

