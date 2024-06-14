<?php
require_once 'Controllers/MarcaController.php';

$controller = new MarcaController();
try {
    $Marcas = $controller->listarMarcas();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}

?>

<div class="card">
    <div class="card-body">
        <h2 class="text-center" style="font-size:34px !important">Marca</h2>
        <div class="Crear">
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
        <div class="CrearMostrar">
        <form id="marcaForm">
    <div class="form-row">
        <div class="col-md-6">
            <label class="control-label">Marca</label>
            <input name="Marca" id="Marca" class="form-control letras" />
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
     $(document).ready(function() {
        $('.Crear').show();
        $('.CrearMostrar').hide();
      
    });

    $('#guardarBtn').click(function() {
        var marca = $('#Marca').val();

        $.ajax({
            url: 'Controllers/AjaxController.php', // Asegúrate de que la URL sea correcta
            type: 'POST',
            data: { accion: 'insertar', Marca: marca },
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert('Marca insertada correctamente');
                        location.reload(); // Recargar la página para ver los cambios
                    } else {
                        alert('Error al insertar la marca: ' + result.message);
                    }
                } catch (e) {
                    alert('Error de formato en la respuesta del servidor.');
                    console.log('Respuesta recibida:', response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
    $('#AbrirModal').click(function() {
        $('.Crear').hide();
        $('.CrearMostrar').show();
    });
</script>
