
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Blank Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="Views/Resources/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="Views/Resources/dist/css/adminlte.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="Views/Resources/css/IziToast.css">
    
    <script src="Views/Resources/js/JqueryVS3_7_1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    




  </head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- HEADER -->
  <?php include "Modules/Header.php"?>
  <!-- /.HEADER -->

  <!-- Main Sidebar Container -->
  <?php include "Modules/Menu.php"?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding: 0px 20px;">
  <?php 
set_include_path(get_include_path() . PATH_SEPARATOR . '/Services/validarAcceso.php');


    if (isset($_GET["Pages"])) {
        $pages = array("facturas", "inventario", "marcas", "joyas", "clientes", "Proveedores", "empleados", "usuarios", "usuariosagregar", "facturacompra", "usuarioss/nuevo", "maquillajes", "Reparaciones", "Roles", "FacturaVenta", "Controldestock","dashboard");

      if ($_GET["Pages"] == "facturas" || $_GET["Pages"] == "inventario" || $_GET["Pages"] == "marcas"|| $_GET["Pages"] == "joyas"|| $_GET["Pages"] == "clientes" || $_GET["Pages"] == "Proveedores" || $_GET["Pages"] == "empleados" || $_GET["Pages"] == "usuarios" || $_GET["Pages"] == "usuariosagregar" || $_GET["Pages"] == "facturacompra" || $_GET["Pages"] == "usuarioss/nuevo" || $_GET["Pages"] == "maquillajes" || $_GET["Pages"] == "Reparaciones" || $_GET["Pages"] == "Roles"|| $_GET["Pages"] == "FacturaVenta"|| $_GET["Pages"] == "transferencias"|| $_GET["Pages"] == "RestablecerContra") {

        include "Pages/". $_GET["Pages"] . ".php";
      }
    }
?>


 
  </div>
  <!-- /.content-wrapper -->


  <?php include "Modules/Footer.php"?>
  

  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">

  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<!-- AdminLTE App -->
<script src="Views/Resources/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Views/Resources/dist/js/demo.js"></script>
<script src="Views/Resources/js/IziToast.js"></script>
<script src="Views/Resources/js/site.js" ></script>
<script>
  
  $(document).ready(function () {

    $("#tablaOne").DataTable({
                /* responsive: true,*/
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }

                }
            })

           
})
 
</script>
</body>
</html>
