<?php
require_once 'config.php';
require_once 'Controllers/ProveedorController.php';

$controller = new ProveedoresController($pdo);
try {
    $Proveedor = $controller->listarProveedores();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>



<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Proveedor</h2>
        <div class="CrearOcultar">
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
                                <td><?php echo $Proveedor['Muni_Municipio']; ?></td>
                                <td class="d-flex justify-content-center" style="gap:10px">
                                    <a class="btn btn-primary btn-sm abrir-editar"><i class="fas fa-edit"></i> Editar</a>
                                    <a class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Detalles</a>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-eraser"></i> Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="CrearMostrar">
            <form>
                <div class="form-row">
                    <div class="col-md-6">
                        <label class="control-label">Proveedor</label>
                        <input name="Proveedor" id="Proveedor" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Telefono</label>
                        <input name="Telefono" id="Telefono" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Municipio</label>
                        <input name="Municipio" id="Municipio" class="form-control letras" />
                        <span class="text-danger"></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row d-flex justify-content-end">
                        <div class="col-md-3">
                            <input type="button" value="Guardar" class="btn btn-primary" id="guardarBtn" />
                        </div>
                        <div class="col-md-3">
                            <a id="CerrarModal" class="btn btn-secondary" style="color:white">Volver</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
   $(document).ready(function () {
       $('.CrearOcultar').show();
       $('.CrearMostrar').hide();
   });

   $('#AbrirModal').click(function() {
       $('.CrearOcultar').hide();
       $('.CrearMostrar').show();
   });

   $('#CerrarModal').click(function() {
       $('.CrearOcultar').show();
       $('.CrearMostrar').hide();
   });

   $('#guardarBtn').click(function() {
    // Capturar los datos del formulario
    var proveedor = $('#Proveedor').val();
    var telefono = $('#Telefono').val();
    var municipio = $('#Municipio').val();

    // Mostrar los datos capturados en la consola
    console.log("Datos enviados:", {
        Prov_Proveedor: proveedor,
        Prov_Telefono: telefono,
        Muni_Codigo: municipio,
        Prov_UsuarioCreacion: 1, // Puedes reemplazar esto con el ID del usuario real
        Prov_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
    });

    // Enviar los datos mediante AJAX
    $.ajax({
        url: 'Controllers/ProveedorController.php',
        type: 'POST',
        data: {
            action: 'insertar',
            Prov_Proveedor: proveedor,
            Prov_Telefono: telefono,
            Muni_Codigo: municipio,
            Prov_UsuarioCreacion: 1, // Puedes reemplazar esto con el ID del usuario real
            Prov_FechaCreacion: new Date().toISOString().slice(0, 19).replace('T', ' ')
        },
        success: function(response) {
            // Mostrar la respuesta en la consola
            console.log("Respuesta recibida:", response);

            if (response == 1) {
                alert('Proveedor guardado exitosamente.');
                // Ocultar el formulario y mostrar la tabla
                $('.CrearMostrar').hide();
                $('.CrearOcultar').show();
            } else {
                alert('Error al guardar el proveedor.');
            }
        },
        error: function() {
            alert('Error en la comunicación con el servidor.');
        }
    });
});


</script>
