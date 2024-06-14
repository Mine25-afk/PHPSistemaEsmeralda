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
    <a class="btn btn-primary btn-sm abrir-editar" data-id="<?php echo $Proveedor['Prov_Id']; ?>"><i class="fas fa-edit"></i> Editar</a>
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
    <input type="hidden" name="Prov_Id" id="Prov_Id">

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



<script>
$(document).ready(function () {
    $('.CrearOcultar').show();
    $('.CrearMostrar').hide();

    $('.abrir-editar').click(function () {
    var provId = $(this).data('id'); // Assuming the button has a data-id attribute with the provider ID
    $.ajax({
        url: 'Controllers/ProveedorController.php',
        type: 'GET',
        data: {
            action: 'buscar',
            Prov_Id: provId
        },
        success: function(response) {
            console.log('Response from server:', response); // Verificar la respuesta del servidor en la consola
            var proveedor = JSON.parse(response);
            $('#Prov_Id').val(provId); // Set Prov_Id in the hidden field
            $('#Proveedor').val(proveedor.Prov_Proveedor);
            $('#Telefono').val(proveedor.Prov_Telefono);
            $('#Municipio').val(proveedor.Muni_Codigo);
            $('.CrearOcultar').hide();
            $('.CrearMostrar').show();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('Error:', errorThrown); // Verificar el error en la consola
            alert('Error al buscar el proveedor.');
        }
    });
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
        var action = $('#Prov_Id').val() ? 'actualizar' : 'insertar'; // Determine action based on whether Prov_Id is set
        var provId = $('#Prov_Id').val();
        var proveedor = $('#Proveedor').val();
        var telefono = $('#Telefono').val();
        var municipio = $('#Municipio').val();
        var usuarioId = 1; // Replace with the actual user ID
        var fecha = new Date().toISOString().slice(0, 19).replace('T', ' ');

        $.ajax({
            url: 'Controllers/ProveedorController.php',
            type: 'POST',
            data: {
                action: action,
                Prov_Id: provId,
                Prov_Proveedor: proveedor,
                Prov_Telefono: telefono,
                Muni_Codigo: municipio,
                Prov_UsuarioCreacion: usuarioId,
                Prov_FechaCreacion: fecha,
                Prov_UsuarioModificacion: usuarioId,
                Prov_FechaModificacion: fecha
            },
            success: function(response) {
                console.log('Response from server:', response); // Verificar la respuesta del servidor en la consola
                if (response == 1) {
                    alert('Proveedor guardado exitosamente.');
                    $('.CrearMostrar').hide();
                    $('.CrearOcultar').show();
                } else {
                    alert('Error al guardar el proveedor.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error:', errorThrown); // Verificar el error en la consola
                alert('Error en la comunicación con el servidor.');
            }
        });
    });
});


</script>
