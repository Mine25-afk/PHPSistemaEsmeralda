<?php
require_once 'Controllers/EmpleadoController.php';

$controller = new EmpleadoController();
try {
    $empleados = $controller->listarEmpleados();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Empleados</h2>

        <p class="btn btn-primary" id="AbrirModal">
            Nuevo
        </p>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>DNI</th>
                        <th>Empleado</th>
                        <th>Correo</th>
                        <th>Estado Civil</th>
                        <th>Sucursal</th>
                        <th>Cargo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td><?php echo $empleado['Empl_DNI']; ?></td>
                            <td><?php echo $empleado['Empleado']; ?></td>
                            <td><?php echo $empleado['Empl_Correo']; ?></td>
                            <td><?php echo $empleado['Esta_EstadoCivil']; ?></td>
                            <td><?php echo $empleado['Sucu_Nombre']; ?></td>
                            <td><?php echo $empleado['Carg_Cargo']; ?></td>
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