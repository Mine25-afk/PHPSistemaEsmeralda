<?php
require_once 'Controllers/ProveedorController.php';

$controller = new ProveedoresController();
try {
    $Proveedor = $controller->listarProveedores();
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
                        <th>Proveedor</th>
                        <th>Telefono</th>
                        <th>Municipio</th>
                     
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Proveedor as $Proveedor): ?>
                        <tr>
                            <td><?php echo $Proveedor['Prov_Id']; ?></td>
                            <td><?php echo $Proveedor['Prov_Proveedor']; ?></td>
                            <td><?php echo $Proveedor['Prov_Telefono']; ?></td>
                            <td><?php echo $Proveedor['Muni_Codigo']; ?></td>
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


