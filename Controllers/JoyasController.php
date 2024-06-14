<?php
require_once 'config.php';

class JoyasController {
    public function listarJoyas() {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listar`()';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar Joyas: ' . $e->getMessage());
        }
    }

    public function insertarJoya($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Joyas_insertar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Joya_Nombre'], $data['Joya_PrecioCompra'], $data['Joya_PrecioVenta'], $data['Joya_PrecioMayor'], $data['Joya_Imagen'], $data['Joya_Stock'], $data['Prov_Id'], $data['Mate_Id'], $data['Cate_Id'], $data['Joya_UsuarioCreacion'], $data['Joya_FechaCreacion']
            ]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al insertar Joya: ' . $e->getMessage());
        }
    }

    public function actualizarJoya($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Joyas_actualizar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Joya_Nombre'], $data['Joya_PrecioCompra'], $data['Joya_PrecioVenta'], $data['Joya_PrecioMayor'], $data['Joya_Imagen'], $data['Joya_Stock'], $data['Prov_Id'], $data['Mate_Id'], $data['Cate_Id'], $data['Joya_UsuarioModificacion'], $data['Joya_FechaModificacion'], $data['Joya_Id']
            ]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al actualizar Joya: ' . $e->getMessage());
        }
    }

    public function eliminarJoya($Joya_Id) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Joyas_eliminar`(?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([$Joya_Id]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al eliminar Joya: ' . $e->getMessage());
        }
    }

    public function obtenerJoya($Joya_Id) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Joyas_obtener`(?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([$Joya_Id]);
            $result = $stmt->fetch();

            if ($result === false) {
                throw new Exception('Error al obtener datos de la joya: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al obtener datos de la joya: ' . $e->getMessage());
        }
    }
}
?>




<form id="formNuevo" enctype="multipart/form-data">
    <!-- otros campos del formulario -->
    <div class="form-group">
        <label for="Joya_Imagen">Imagen</label>
        <input type="file" class="form-control" id="Joya_Imagen" name="Joya_Imagen" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
</form>


// insertarJoya.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new JoyasController();
    
    // Manejo de la subida de archivos
    if (isset($_FILES['Joya_Imagen']) && $_FILES['Joya_Imagen']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'path/to/your/upload/directory/'; // Cambia esta ruta a donde quieras guardar las imágenes
        $uploadFile = $uploadDir . basename($_FILES['Joya_Imagen']['name']);
        
        if (move_uploaded_file($_FILES['Joya_Imagen']['tmp_name'], $uploadFile)) {
            $data = $_POST;
            $data['Joya_Imagen'] = $uploadFile; // Guarda la ruta de la imagen en el array de datos

            try {
                $result = $controller->insertarJoya($data);
                echo json_encode(['success' => true, 'data' => $result]);
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al subir la imagen']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Imagen no subida o error en la subida']);
    }
}


class JoyasController {
    public function insertarJoya($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Joyas_insertar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Joya_Nombre'], $data['Joya_PrecioCompra'], $data['Joya_PrecioVenta'], $data['Joya_PrecioMayor'], $data['Joya_Imagen'], $data['Joya_Stock'], $data['Prov_Id'], $data['Mate_Id'], $data['Cate_Id'], $data['Joya_UsuarioCreacion'], $data['Joya_FechaCreacion']
            ]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al insertar Joya: ' . $e->getMessage());
        }
    }
}


<tbody>
    <?php foreach ($Joyas as $joyas): ?>
        <tr>
            <td><?php echo $joyas['Joya_Nombre']; ?></td>
            <td><?php echo $joyas['Joya_PrecioCompra']; ?></td>
            <td><?php echo $joyas['Joya_PrecioVenta']; ?></td>
            <td><?php echo $joyas['Joya_Stock']; ?></td>
            <td><?php echo $joyas['Joya_PrecioMayor']; ?></td>
            <td><img src="<?php echo $joyas['Joya_Imagen']; ?>" alt="Imagen de Joya" width="100"></td>
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


Asegúrate de cambiar path/to/your/upload/directory/ a la ruta correcta donde deseas guardar las imágenes en tu servidor. También, asegúrate de que esta carpeta tiene permisos de escritura adecuados.