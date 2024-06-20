<style>
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link.active, 
.sidebar-dark-primary .nav-sidebar > .nav-item > .nav-link:hover {
    background-color: #FFECF8;
    color: #000000;
}

.brand-link {
    background-color: #000000;
}

.brand-link .brand-text {
    color: #FFA2DB;
}

.form-control-sidebar {
    background-color: #000000;
    border: 1px solid #FFA2DB;
    color: #FFA2DB;
}

.input-group-append .btn-sidebar {
    background-color: #FFA2DB;
    color: #000000;
}

.modal-header {
    background-color: #FFA2DB;
}

.modal-title {
    color: #000000;
}

.btn-primary {
    background-color: #FFA2DB;
    border-color: #FFA2DB;
    color: #000000;
}

.btn-secondary {
    background-color: #000000;
    border-color: #000000;
    color: #FFA2DB;
}

.nav-item > .nav-treeview {
    display: none;
}

.nav-item.menu-open > .nav-treeview {
    display: block;
}
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000000;">
    <!-- Brand Logo -->
    <a href="Views/Resources/index3.html" class="brand-link" style="text-align: center;">
      <img src="Views/diamante.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8; width: 50px;">
      <span class="brand-text font-weight-light" style="color: #FFA2DB;">Sistema Esmeralda</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="Views/Resources/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="color: #FFA2DB;">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item" id="menu-acceso">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-key" style="color: #FFA2DB;"></i>
              <p style="color: #FFA2DB;">
                Acceso
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="usuarios" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Roles" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Roles</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item" id="menu-generales">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-gem" style="color: #FFA2DB;"></i>
              <p style="color: #FFA2DB;">
                Generales
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="clientes" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="marcas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Marcas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Proveedores" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="empleados" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Empleados</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item" id="menu-ventas">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-bag" style="color: #FFA2DB;"></i>
              <p style="color: #FFA2DB;">
                Ventas
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="joyas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Joyas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="maquillajes" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Maquillajes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Reparaciones" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Reparaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Facturas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Factura compra</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="transferencias" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Transferencias</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item" id="menu-reportes">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-line" style="color: #FFA2DB;"></i>
              <p style="color: #FFA2DB;">
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Control de Stock</p>
                </a>
              </li>    
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Caja</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Ventas por pago</p>
                </a>
              </li>     
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Reporte de ventas</p>
                </a>
              </li>    
            </ul>
          </li>
          
          <li class="nav-item" id="menu-graficos">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie" style="color: #FFA2DB;"></i>
              <p style="color: #FFA2DB;">
                Gráficos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="facturas" class="nav-link">
                  <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
                  <p>Facturas</p>
                </a>
              </li>             
            </ul>
          </li>

          <li class="nav-item">
            <a class="nav-link" id="AbrirCajas">
              <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
              <p>Abrir Caja</p>
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" id="CerrarCajas">
              <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
              <p>Cerrar caja</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="FacturaVenta">
              <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
              <p>Factura Venta</p>
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" id="AbrirRetiro">
              <i class="far fa-circle nav-icon" style="color: #FFA2DB;"></i>
              <p>Retiro caja</p>
            </a>
          </li> 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="AbrirCajaModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #FFA2DB;">
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
                            <input name="Inicial" class="form-control letras" id="Inicial" style="border: 1px solid #FFA2DB;"/>
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
            <div class="modal-header" style="background-color: #FFA2DB;">
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
                            <input name="Final" class="form-control letras" id="Final" style="border: 1px solid #FFA2DB;"/>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Observaciones</label>
                            <input name="Observaciones" class="form-control letras" id="Observaciones" style="border: 1px solid #FFA2DB;"/>
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
            <div class="modal-header" style="background-color: #FFA2DB;">
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
                            <input name="Efectivo" class="form-control letras" id="Efectivo" style="border: 1px solid #FFA2DB;"/>
                            <span class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Observaciones</label>
                            <input name="ObservacionesRe" class="form-control letras" id="ObservacionesRe" style="border: 1px solid #FFA2DB;"/>
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
  document.addEventListener('DOMContentLoaded', (event) => {
    // Obtener todos los elementos nav-item que tienen submenús
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach((navItem) => {
      // Obtener el enlace dentro del nav-item
      const navLink = navItem.querySelector('.nav-link');

      // Añadir un evento de clic al enlace
      navLink.addEventListener('click', (e) => {
        // Prevenir el comportamiento predeterminado del enlace solo si tiene submenú
        const subMenu = navItem.querySelector('.nav-treeview');
        if (subMenu) {
          e.preventDefault();

          // Alternar la clase menu-open en el nav-item para abrir o cerrar el submenú
          if (navItem.classList.contains('menu-open')) {
            navItem.classList.remove('menu-open');
            subMenu.style.display = 'none';
          } else {
            // Cerrar cualquier otro submenú abierto antes de abrir el seleccionado
            const openItems = document.querySelectorAll('.nav-item.menu-open');
            openItems.forEach((openItem) => {
              openItem.classList.remove('menu-open');
              const openSubMenu = openItem.querySelector('.nav-treeview');
              if (openSubMenu) {
                openSubMenu.style.display = 'none';
              }
            });
            navItem.classList.add('menu-open');
            subMenu.style.display = 'block';
          }
        }
      });

      // Añadir eventos de clic a los enlaces dentro del submenú para evitar que se cierre
      const subMenuLinks = navItem.querySelectorAll('.nav-treeview .nav-link');
      subMenuLinks.forEach((subMenuLink) => {
        subMenuLink.addEventListener('click', (e) => {
          e.stopPropagation();
        });
      });
    });
  });
</script>



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

