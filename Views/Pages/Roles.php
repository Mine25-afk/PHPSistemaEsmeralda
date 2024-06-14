<?php
require_once 'Controllers/RolesController.php';

$controller = new RolesController();
try {
    $Roles = $controller->listarRoles();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Roles</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Rol</th>
                     
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Roles as $Roles): ?>
                        <tr>
                            <td><?php echo $Roles['Role_Id']; ?></td>
                            <td><?php echo $Roles['Role_Rol']; ?></td>
                            <td class="d-flex justify-content-center" style="gap:10px">
                                <a class="btn btn-primary btn-sm abrir-editar"><i class="fas fa-edit"></i>Editar</a>
                                <a class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i>Detalles</a>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


