<?php
require_once 'Controllers/UsuarioController.php';

$controller = new UsuarioController();
try {
    $usuarios = $controller->insertarUsuarios();
} catch (Exception $e) {
    echo 'Error: '. $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h3><b>Usuarios</b></h3>
</div>
        <div class="card-body">

            <p class="btn btn-primary" id="AbrirModal">
                Nuevo
            </p>
        </div>
    </div>
                        </div>
                        </div>
                        </div>
</body>
</html>
