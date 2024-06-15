<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" id="logoutLink" href="#" role="button"><i class='fas fa-arrow-right'></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
 
  </nav>

  <script>
    $(document).ready(function () {
        $('#logoutLink').click(function (e) {
            e.preventDefault();
            window.location.href = 'Views/Modules/Salir.php';
        });
    });
</script>