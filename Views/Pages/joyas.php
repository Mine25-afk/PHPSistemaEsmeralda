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

        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseNuevo" aria-expanded="false" aria-controls="collapseNuevo">
            Nuevo
        </button>

        <div class="collapse" id="collapseNuevo">
            <div class="card card-body">
                <form id="formNuevo">
                    <div class="form-group">
                        <label for="Joya_Nombre">Descripción</label>
                        <input type="text" class="form-control" id="Joya_Nombre" name="Joya_Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioCompra">Precio Compra</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioCompra" name="Joya_PrecioCompra" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioVenta">Precio Venta</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioVenta" name="Joya_PrecioVenta" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_Stock">Stock</label>
                        <input type="number" class="form-control" id="Joya_Stock" name="Joya_Stock" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioMayor">Precio Mayorista</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioMayor" name="Joya_PrecioMayor" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_Imagen">Imagen</label>
                        <input type="text" class="form-control" id="Joya_Imagen" name="Joya_Imagen" required>
                    </div>
                    <div class="form-group">
                        <label for="Mate_Id">Material</label>
                        <input type="text" class="form-control" id="Mate_Id" name="Mate_Id" required>
                    </div>
                    <div class="form-group">
                        <label for="Prov_Id">Proveedor</label>
                        <input type="text" class="form-control" id="Prov_Id" name="Prov_Id" required>
                    </div>
                    <div class="form-group">
                        <label for="Cate_Id">Categoría</label>
                        <input type="text" class="form-control" id="Cate_Id" name="Cate_Id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>

        <hr>

        <div class="table-responsive">
            <table class="table table-striped table-hover" id="tablaOne">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th>Precio Mayorista</th>
                        <th>Imagen</th>
                        <th>Material</th>
                        <th>Proveedor</th>
                        <th>Categoría</th>
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
                                <button class="btn btn-primary btn-sm abrir-editar" data-id="<?php echo $joyas['Joya_Id']; ?>"><i class="fas fa-edit"></i>Editar</button>
                                <button class="btn btn-secondary btn-sm abrir-detalles" data-id="<?php echo $joyas['Joya_Id']; ?>"><i class="fas fa-eye"></i>Detalles</button>
                                <button class="btn btn-danger btn-sm eliminar" data-id="<?php echo $joyas['Joya_Id']; ?>"><i class="fas fa-eraser"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="collapse" id="collapseEditar">
            <div class="card card-body">
                <form id="formEditar">
                    <input type="hidden" id="Joya_Id_Editar" name="Joya_Id">
                    <div class="form-group">
                        <label for="Joya_Nombre_Editar">Descripción</label>
                        <input type="text" class="form-control" id="Joya_Nombre_Editar" name="Joya_Nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioCompra_Editar">Precio Compra</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioCompra_Editar" name="Joya_PrecioCompra" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioVenta_Editar">Precio Venta</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioVenta_Editar" name="Joya_PrecioVenta" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_Stock_Editar">Stock</label>
                        <input type="number" class="form-control" id="Joya_Stock_Editar" name="Joya_Stock" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_PrecioMayor_Editar">Precio Mayorista</label>
                        <input type="number" step="0.01" class="form-control" id="Joya_PrecioMayor_Editar" name="Joya_PrecioMayor" required>
                    </div>
                    <div class="form-group">
                        <label for="Joya_Imagen_Editar">Imagen</label>
                        <input type="text" class="form-control" id="Joya_Imagen_Editar" name="Joya_Imagen" required>
                    </div>
                    <div class="form-group">
                        <label for="Mate_Id_Editar">Material</label>
                        <input type="text" class="form-control" id="Mate_Id_Editar" name="Mate_Id" required>
                    </div>
                    <div class="form-group">
                        <label for="Prov_Id_Editar">Proveedor</label>
                        <input type="text" class="form-control" id="Prov_Id_Editar" name="Prov_Id" required>
                    </div>
                    <div class="form-group">
                        <label for="Cate_Id_Editar">Categoría</label>
                        <input type="text" class="form-control" id="Cate_Id_Editar" name="Cate_Id" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>

        <div class="collapse" id="collapseDetalles">
            <div class="card card-body">
                <p id="detallesContenido"></p>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('formNuevo').addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('ajax/insertarJoya.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al insertar joya');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.querySelectorAll('.abrir-editar').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            fetch(`ajax/obtenerJoya.php?Joya_Id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('Joya_Id').value = data.joya.Joya_Id;
                    document.getElementById('Joya_Nombre').value = data.joya.Joya_Nombre;
                    document.getElementById('Joya_PrecioCompra').value = data.joya.Joya_PrecioCompra;
                    document.getElementById('Joya_PrecioVenta').value = data.joya.Joya_PrecioVenta;
                    document.getElementById('Joya_Stock').value = data.joya.Joya_Stock;
                    document.getElementById('Joya_PrecioMayor').value = data.joya.Joya_PrecioMayor;
                    document.getElementById('Joya_Imagen').value = data.joya.Joya_Imagen;
                    document.getElementById('Mate_Id').value = data.joya.Mate_Id;
                    document.getElementById('Prov_Id').value = data.joya.Prov_Id;
                    document.getElementById('Cate_Id').value = data.joya.Cate_Id;
                    $('#collapseEditar').collapse('show');
                } else {
                    alert('Error al obtener datos de la joya');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    document.getElementById('formEditar').addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('ajax/actualizarJoya.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar joya');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.querySelectorAll('.abrir-detalles').forEach(function (button) {
        button.addEventListener('click', function () {
            var id = this.getAttribute('data-id');
            fetch(`ajax/obtenerJoya.php?Joya_Id=${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var detalles = `
                        <p>Descripción: ${data.joya.Joya_Nombre}</p>
                        <p>Precio Compra: ${data.joya.Joya_PrecioCompra}</p>
                        <p>Precio Venta: ${data.joya.Joya_PrecioVenta}</p>
                        <p>Stock: ${data.joya.Joya_Stock}</p>
                        <p>Precio Mayorista: ${data.joya.Joya_PrecioMayor}</p>
                        <p>Imagen: ${data.joya.Joya_Imagen}</p>
                        <p>Material: ${data.joya.Mate_Material}</p>
                        <p>Proveedor: ${data.joya.Prov_Proveedor}</p>
                        <p>Categoría: ${data.joya.Cate_Categoria}</p>
                    `;
                    document.getElementById('detallesContenido').innerHTML = detalles;
                    $('#collapseDetalles').collapse('show');
                } else {
                    alert('Error al obtener detalles de la joya');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });

    document.querySelectorAll('.eliminar').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!confirm('¿Estás seguro de que quieres eliminar esta joya?')) return;

            var id = this.getAttribute('data-id');
            fetch(`ajax/eliminarJoya.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `Joya_Id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al eliminar joya');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>

<?php
// insertarJoya.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new JoyasController();
    $data = $_POST; 
    try {
        $result = $controller->insertarJoya($data);
        echo json_encode(['success' => true, 'data' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// actualizarJoya.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new JoyasController();
    $data = $_POST; 
    try {
        $result = $controller->actualizarJoya($data);
        echo json_encode(['success' => true, 'data' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// eliminarJoya.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new JoyasController();
    $Joya_Id = $_POST['Joya_Id']; 
    try {
        $result = $controller->eliminarJoya($Joya_Id);
        echo json_encode(['success' => true, 'data' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}

// obtenerJoya.php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new JoyasController();
    $Joya_Id = $_GET['Joya_Id']; 
    try {
        $result = $controller->obtenerJoya($Joya_Id);
        echo json_encode(['success' => true, 'joya' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
