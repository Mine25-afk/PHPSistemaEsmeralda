<?php
require_once 'Controllers/JoyasController.php';

$controller = new JoyasController();
try {
    $Joyas = $controller->listarJoyas();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Joyas</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>Descripcion</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th>Precio Mayorista</th>
                        <th>Imagen</th>
                        <th>Material</th>
                        <th>Proveedor</th>
                        <th>Categoria</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Joyas as $joyas): ?>
                        <tr>
                            <td><?php echo $joyas['Joya_Nombre']; ?></td>
                            <td><?php echo $joyas['Joya_PrecioCompra']; ?></td>
                            <td><?php echo $joyas['Joya_PrecioVenta']; ?></td>
                            <td><?php echo $joyas['Joya_Stock']; ?></td>
                            <td><?php echo $joyas['Joya_PrecioMayor']; ?></td>
                            <td><?php echo $joyas['Joya_Imagen']; ?></td>
                            <td><?php echo $joyas['Mate_Material']; ?></td>
                            <td><?php echo $joyas['Prov_Proveedor']; ?></td>
                            <td><?php echo $joyas['Cate_Categoria']; ?></td>
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