
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
  <link rel="stylesheet" href="Views/Resources/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="Views/Resources/css/DataTable.css">
    <link rel="stylesheet" href="Views/Resources/css/IziToast.css">
    <script src="Views/Resources/js/JqueryVS3_7_1.js"></script>
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
  <div class="content-wrapper">
  <?php 
    if (isset($_GET["Pages"])) {
      if ($_GET["Pages"] == "facturas" || $_GET["Pages"] == "inventario" || $_GET["Pages"] == "marcas") {
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

<script src="Views/Resources/dist-layout/vendor/jquery/jquery.min.js"></script>
<script src="Views/Resources/dist-layout/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="Views/Resources/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Views/Resources/dist/js/demo.js"></script>
<script src="Views/Resources/js/IziToast.js"></script>
<script src="Views/Resources/js/site.js" ></script>
<script src="Views/Resources/js/jquery-ui.js" ></script>
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
