<?php
require_once 'Controllers/MarcaController.php';

$controller = new MarcaController();
try {
    $Marcas = $controller->listarMarcas();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Marca</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Marcas as $marcas): ?>
                        <tr>
                            <td><?php echo $marcas['Marc_Id']; ?></td>
                            <td><?php echo $marcas['Marc_Marca']; ?></td>
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
