<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Navbar</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMQm2aC5P2mP1CpFJ5oz99KfuDHGmoP8vZ1XK5n" crossorigin="anonymous">
    <style>
        .navbar-custom {
            background-color: #000000; /* Cambia el color de fondo */
            color: #fff; /* Cambia el color del texto */
        }

        .navbar-custom .nav-link {
            color: #fff; /* Cambia el color de los enlaces */
        }

        .navbar-custom .nav-link:hover {
            color: #ffb3ce; /* Cambia el color de los enlaces al pasar el ratón */
        }

        .navbar-custom .fa-bars,
        .navbar-custom .fa-arrow-right {
            color: #fff; /* Cambia el color de los iconos */
        }

        .navbar-custom .fa-bars:hover,
        .navbar-custom .fa-arrow-right:hover {
            color: #ffb3ce; /* Cambia el color de los iconos al pasar el ratón */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <nav class="main-header navbar navbar-expand navbar-custom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" id="logoutLink" href="#" role="button">Cerrar Sesion <i class='fas fa-arrow-right'></i></a>
            </li>
        </ul>
    </nav>

    <script>
        $(document).ready(function () {
            $('#logoutLink').click(function (e) {
                e.preventDefault();
                window.location.href = 'Views/Modules/Salir.php';
            });
        });
    </script>
</body>
</html>
