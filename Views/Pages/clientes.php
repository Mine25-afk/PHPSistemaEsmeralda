<?php
require_once 'Controllers/ClientesController.php';

$controller = new ClientesController();
try {
    $Clientes = $controller->listarClientes();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Clientes</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                        <th>Municipio</th>                      
                        <th>Estado Civil</th>
                        <th>Mayorista</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($Clientes as $clientes): ?>
                        <tr>
                            <td><?php echo $clientes['Clie_Nombre']; ?></td>
                            <td><?php echo $clientes['Clie_DNI']; ?></td>
                            <td><?php echo $clientes['Clie_FechaNac']; ?></td>
                            <td><?php echo $clientes['Clie_Sexo']; ?></td>
                            <td><?php echo $clientes['Municipio']; ?></td>
                            <td><?php echo $clientes['Estado_Civil']; ?></td>
                            <td><?php echo $clientes['Clie_esMayorista']; ?></td>
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