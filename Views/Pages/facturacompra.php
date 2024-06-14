<?php
require_once 'Controllers/FacturaCompraController.php';

$controller = new FacturaCompraController();
try {
    $facturascompras = $controller->listarFacturaCompra();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Factura Compra</h2>

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
                        <th>Metodo de Pago</th>
                        <th>Fecha Finalizada</th>
                        <th>Finalizada</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($facturascompras as $facturacompra): ?>
                        <tr>
                            <td><?php echo $facturacompra['FaCE_Id']; ?></td>
                            <td><?php echo $facturacompra['nombreProveedor']; ?></td>
                            <td><?php echo $facturacompra['mepa_Metodo']; ?></td>
                            <td><?php echo $facturacompra['faCE_fechafinalizacion']; ?></td>
                            <td><?php echo $facturacompra['faCE_Finalizada']; ?></td>
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