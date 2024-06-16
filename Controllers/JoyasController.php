<?php
require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');
class JoyasController {
    // Métodos existentes...

    public function listarJoyas() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar joyas: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar joyas: ' . $e->getMessage()));
        }
    }

    public function listarProveedores() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Proveedor_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar proveedores: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar proveedores: ' . $e->getMessage()));
        }
    }

    public function listarMateriales() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Materiales_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar materiales: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar materiales: ' . $e->getMessage()));
        }
    }

    public function listarCategorias() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Categorias_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar categorías: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar categorías: ' . $e->getMessage()));
        }
    }

    public function insertarJoyas($Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Mate_Id, $Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion) {
        global $pdo;
        try {
            if (isset($Joya_Imagen['error']) && $Joya_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/joyas/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($Joya_Imagen['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($Joya_Imagen['tmp_name'], $targetFilePath)) {
                    $Joya_Imagen = $fileName; // Guarda solo el nombre del archivo
                } else {
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                throw new Exception('Error al subir el archivo: ' . $Joya_Imagen['error']);
            }
    
            $sql = 'CALL SP_Joyas_insertar(:Joya_Nombre, :Joya_PrecioCompra, :Joya_PrecioVenta, :Joya_PrecioMayor, :Joya_Imagen, :Joya_Stock, :Prov_Id, :Mate_Id, :Cate_Id, :Joya_UsuarioCreacion, :Joya_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Nombre', $Joya_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioCompra', $Joya_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioVenta', $Joya_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioMayor', $Joya_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Imagen', $Joya_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Stock', $Joya_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Mate_Id', $Mate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Cate_Id', $Cate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_UsuarioCreacion', $Joya_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_FechaCreacion', $Joya_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
    
            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar joya: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al insertar joya: ' . $e->getMessage()));
            return 0;
        }
    }
    
    
    public function actualizarJoyas($Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Mate_Id, $Cate_Id, $Joya_UsuarioModificacion, $Joya_FechaModificacion, $Joya_Id) {
        global $pdo;
        try {
            if (isset($Joya_Imagen['error']) && $Joya_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/joyas/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($Joya_Imagen['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($Joya_Imagen['tmp_name'], $targetFilePath)) {
                    // Guarda solo el nombre del archivo en la base de datos
                    $Joya_Imagen = $fileName;
                } else {
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                $joya = $this->buscarJoya($Joya_Id);
                $Joya_Imagen = $joya['Joya_Imagen'];
            }
    
            $sql = 'CALL SP_Joyas_actualizar(:Joya_Nombre, :Joya_PrecioCompra, :Joya_PrecioVenta, :Joya_PrecioMayor, :Joya_Imagen, :Joya_Stock, :Prov_Id, :Mate_Id, :Cate_Id, :Joya_UsuarioModificacion, :Joya_FechaModificacion, :Joya_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Nombre', $Joya_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioCompra', $Joya_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioVenta', $Joya_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioMayor', $Joya_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Imagen', $Joya_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Stock', $Joya_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Mate_Id', $Mate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Cate_Id', $Cate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_UsuarioModificacion', $Joya_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_FechaModificacion', $Joya_FechaModificacion, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Id', $Joya_Id, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al actualizar joya: ' . $e->getMessage());
            return 0;
        }
    }
    

    public function eliminarJoyas($Joya_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Joyas_eliminar(:Joya_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Id', $Joya_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar joya: ' . $e->getMessage());
            return 0;
        }
    }

    public function buscarJoya($Joya_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Joyas_buscar(:Joya_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Id', $Joya_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al buscar joya: ' . $e->getMessage());
            return null;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new JoyasController();

    switch ($_POST['action']) {
        case 'listarJoyas':
            $controller->listarJoyas();
            break;
        case 'listarProveedores':
            $controller->listarProveedores();
            break;
        case 'listarMateriales':
            $controller->listarMateriales();
            break;
        case 'listarCategorias':
            $controller->listarCategorias();
            break;
        case 'insertar':
            $Joya_Nombre = $_POST['Joya_Nombre'];
            $Joya_PrecioCompra = $_POST['Joya_PrecioCompra'];
            $Joya_PrecioVenta = $_POST['Joya_PrecioVenta'];
            $Joya_PrecioMayor = $_POST['Joya_PrecioMayor'];
            $Joya_Imagen = $_FILES['Joya_Imagen'];
            $Joya_Stock = $_POST['Joya_Stock'];
            $Prov_Id = $_POST['Prov_Id'];
            $Mate_Id = $_POST['Mate_Id'];
            $Cate_Id = $_POST['Cate_Id'];
            $Joya_UsuarioCreacion = $_POST['Joya_UsuarioCreacion'];
            $Joya_FechaCreacion = $_POST['Joya_FechaCreacion'];

            $resultado = $controller->insertarJoyas($Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Mate_Id, $Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion);
            echo json_encode(array('result' => $resultado));
            break;
        case 'actualizar':
            $Joya_Nombre = $_POST['Joya_Nombre'];
            $Joya_PrecioCompra = $_POST['Joya_PrecioCompra'];
            $Joya_PrecioVenta = $_POST['Joya_PrecioVenta'];
            $Joya_PrecioMayor = $_POST['Joya_PrecioMayor'];
            $Joya_Imagen = $_FILES['Joya_Imagen'];
            $Joya_Stock = $_POST['Joya_Stock'];
            $Prov_Id = $_POST['Prov_Id'];
            $Mate_Id = $_POST['Mate_Id'];
            $Cate_Id = $_POST['Cate_Id'];
            $Joya_UsuarioModificacion = $_POST['Joya_UsuarioModificacion'];
            $Joya_FechaModificacion = $_POST['Joya_FechaModificacion'];
            $Joya_Id = $_POST['Joya_Id'];

            $resultado = $controller->actualizarJoyas($Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Mate_Id, $Cate_Id, $Joya_UsuarioModificacion, $Joya_FechaModificacion, $Joya_Id);
            echo json_encode(array('result' => $resultado));
            break;
        case 'eliminar':
            $Joya_Id = $_POST['Joya_Id'];
            $resultado = $controller->eliminarJoyas($Joya_Id);
            echo json_encode(array('result' => $resultado));
            break;
        case 'buscar':
            $Joya_Id = $_POST['Joya_Id'];
            $resultado = $controller->buscarJoya($Joya_Id);
            echo json_encode($resultado);
            break;
    }
}
?>
