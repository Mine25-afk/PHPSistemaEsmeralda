<?php
require_once 'Controllers/UsuarioController.php';

$controller = new UsuarioController();
try {
    $usuarios = $controller->listarUsuarios();
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
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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

        <a href="usuariosagregar" class="btn btn-primary">
                Nuevo
            </a>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Administrador</th>
                            <th>Empleado</th>
                            <th>Rol</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario):?>
                            <tr>
                                <td><?php echo $usuario['Usua_Usuario'];?></td>
                                <td><?php echo $usuario['Usua_Administradores'];?></td>
                                <td><?php echo $usuario['Empleado'];?></td>
                                <td><?php echo $usuario['Role_Rol'];?></td>
                                <td class="d-flex justify-content-center" style="gap:10px">
                                    <a class="btn btn-primary btn-sm abrir-editar"><i class="fas fa-edit"></i>Editar</a>
                                    <a class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i>Detalles</a>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                        </div>
                        </div>
                        </div>

    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-qFOQ9YFAeGj1gDOuUD61g3D+tLDv3u1ECYWqT82WQoaWrOhAY+5mRMTTVsQdWutbA5FORCnkEPEgU0OF8IzGvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            let table = new DataTable('#myTable', {
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                }
            });
        });
    </script>
</body>
</html>
