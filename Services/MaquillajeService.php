<?php
require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
session_start();
ini_set('error_log', '/path/to/php-error.log');

class MaquillajeService {
    public function listarMaquillaje() {
        global $pdo;
        try {
            $sql = 'CALL SP_Maquillajes_listar()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Maqu_Codigo' => $row['Maqu_Codigo'],
                    'Maqu_Id' => $row['Maqu_Id'],
                    'Maqu_Nombre' => $row['Maqu_Nombre'],
                    'Maqu_PrecioCompra' => $row['Maqu_PrecioCompra'],
                    'Maqu_PrecioVenta' => $row['Maqu_PrecioVenta'],
                    'Maqu_PrecioMayor' => $row['Maqu_PrecioMayor'],
                    'Maqu_Imagen' => $row['Maqu_Imagen'],
                    'Marc_Id' => $row['Marc_Id'],
                    'Prov_Id' => $row['Prov_Id'],
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            error_log('Error al listar maquillajes: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar maquillajes: ' . $e->getMessage()));
        }
    }

    public function listarMarcas() {
        global $pdo;
        try {
            $sql = 'CALL SP_Marcas_Listar()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar marcas: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar marcas: ' . $e->getMessage()));
        }
    }

    public function insertarMaquillaje($Maqu_Id, $Maqu_Nombre, $Maqu_PrecioCompra, $Maqu_PrecioVenta, $Maqu_PrecioMayor, $Maqu_Imagen, $Prov_Id, $Marc_Id, $Maqu_FechaCreacion) {
        global $pdo;
        try {
            // Verificar si se subió el archivo sin errores
            if (isset($Maqu_Imagen['error']) && $Maqu_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/maquillajes/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileInfo = pathinfo($Maqu_Imagen['name']);
                $extension = $fileInfo['extension'];
                $uniqueName = uniqid() . '.' . $extension;
                $targetFilePath = $uploadDir . $uniqueName;

                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($Maqu_Imagen['tmp_name'], $targetFilePath)) {
                    $Maqu_Imagen = $uniqueName;
                } else {
                    error_log('Error al mover el archivo subido.');
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                error_log('Error al subir el archivo: ' . $Maqu_Imagen['error']);
                throw new Exception('Error al subir el archivo: ' . $Maqu_Imagen['error']);
            }

            $Maqu_Stock = 1;
            $sql = 'CALL SP_Maquillajes_insertar(:Maqu_Nombre, :Maqu_PrecioCompra, :Maqu_PrecioVenta, :Maqu_PrecioMayor, :Maqu_Stock, :Maqu_Imagen, :Prov_Id, :Marc_Id, :Maqu_UsuarioCreacion, :Maqu_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Maqu_Nombre', $Maqu_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioCompra', $Maqu_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioVenta', $Maqu_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioMayor', $Maqu_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_Stock', $Maqu_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_Imagen', $Maqu_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Marc_Id', $Marc_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_UsuarioCreacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_FechaCreacion', $Maqu_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar maquillaje: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al insertar maquillaje: ' . $e->getMessage()));
            return 0;
        }
    }

    public function actualizarMaquillaje($Maqu_Id, $Maqu_Nombre, $Maqu_PrecioCompra, $Maqu_PrecioVenta, $Maqu_PrecioMayor, $Maqu_Imagen, $Prov_Id, $Marc_Id, $Maqu_FechaCreacion) {
        global $pdo;
        try {
            // Verificar si se subió una nueva imagen
            if (isset($Maqu_Imagen['error']) && $Maqu_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/maquillajes/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileInfo = pathinfo($Maqu_Imagen['name']);
                $extension = $fileInfo['extension'];
                $uniqueName = uniqid() . '.' . $extension;
                $targetFilePath = $uploadDir . $uniqueName;
    
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($Maqu_Imagen['tmp_name'], $targetFilePath)) {
                    $Maqu_Imagen = $uniqueName;
                } else {
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                // Mantener la imagen existente si no se subió una nueva
                $stmt = $pdo->prepare('SELECT Maqu_Imagen FROM Vent_tbMaquillajes WHERE Maqu_Id = :Maqu_Id');
                $stmt->bindParam(':Maqu_Id', $Maqu_Id, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $Maqu_Imagen = $stmt->fetchColumn();
                } else {
                    throw new Exception('No se encontró la imagen existente.');
                }
            }
    
            $Maqu_Stock = 1;
            $sql = 'CALL SP_Maquillajes_actualizar(:Maqu_Id, :Maqu_Nombre, :Maqu_PrecioCompra, :Maqu_PrecioVenta, :Maqu_PrecioMayor, :Maqu_Stock, :Maqu_Imagen, :Prov_Id, :Marc_Id, :Maqu_UsuarioModificacion, :Maqu_FechaModificacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Maqu_Id', $Maqu_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_Nombre', $Maqu_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioCompra', $Maqu_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioVenta', $Maqu_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_PrecioMayor', $Maqu_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Maqu_Stock', $Maqu_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_Imagen', $Maqu_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Marc_Id', $Marc_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_UsuarioModificacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Maqu_FechaModificacion', $Maqu_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
    
            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al actualizar maquillaje: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al actualizar maquillaje: ' . $e->getMessage()));
            return 0;
        }
    }
    
    

    public function eliminarMaquillaje($Maqu_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL SP_Maquillajes_eliminar(:Maqu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Maqu_Codigo', $Maqu_Codigo, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar maquillaje: ' . $e->getMessage());
            return 0;
        }
    }

    public function buscarMaquillaje($Maqu_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Maquillajes_buscar(:Maqu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Maqu_Codigo', $Maqu_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result ? $result : []));
        } catch (PDOException $e) {
            error_log('Error al buscar maquillaje: ' . $e->getMessage());
            return null;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new MaquillajeService();

    switch ($_POST['action']) {
        case 'listarMaquillaje':
            $controller->listarMaquillaje();
            break;
        case 'listarMarcas':
            $controller->listarMarcas();
            break;
        case 'insertar':
            $Maqu_Id = $_POST['Maqu_Id'];
            $Maqu_Nombre = $_POST['Maqu_Nombre'];
            $Maqu_PrecioCompra = $_POST['Maqu_PrecioCompra'];
            $Maqu_PrecioVenta = $_POST['Maqu_PrecioVenta'];
            $Maqu_PrecioMayor = $_POST['Maqu_PrecioMayor'];
            $Maqu_Imagen = $_FILES['Maqu_Imagen'];
            $Prov_Id = $_POST['Prov_Id'];
            $Marc_Id = $_POST['Marc_Id'];
            $Maqu_FechaCreacion = $_POST['Maqu_FechaCreacion'];

            $resultado = $controller->insertarMaquillaje($Maqu_Id, $Maqu_Nombre, $Maqu_PrecioCompra, $Maqu_PrecioVenta, $Maqu_PrecioMayor, $Maqu_Imagen, $Prov_Id, $Marc_Id, $Maqu_FechaCreacion);
            echo json_encode(array('result' => $resultado));
            break;
        case 'actualizar':
            $Maqu_Id = $_POST['Maqu_Id'];
            $Maqu_Nombre = $_POST['Maqu_Nombre'];
            $Maqu_PrecioCompra = $_POST['Maqu_PrecioCompra'];
            $Maqu_PrecioVenta = $_POST['Maqu_PrecioVenta'];
            $Maqu_PrecioMayor = $_POST['Maqu_PrecioMayor'];
            $Maqu_Imagen = $_FILES['Maqu_Imagen'];
            $Prov_Id = $_POST['Prov_Id'];
            $Marc_Id = $_POST['Marc_Id'];
            $Maqu_FechaCreacion = $_POST['Maqu_FechaCreacion'];

            $resultado = $controller->actualizarMaquillaje($Maqu_Id, $Maqu_Nombre, $Maqu_PrecioCompra, $Maqu_PrecioVenta, $Maqu_PrecioMayor, $Maqu_Imagen, $Prov_Id, $Marc_Id, $Maqu_FechaCreacion);
            echo json_encode(array('result' => $resultado));
            break;
        case 'eliminar':
            $Maqu_Codigo = $_POST['Maqu_Codigo'];
            $resultado = $controller->eliminarMaquillaje($Maqu_Codigo);
            echo json_encode(array('result' => $resultado));
            break;
        case 'buscar':
            $Maqu_Id = $_POST['Maqu_Id'];
            $resultado = $controller->buscarMaquillaje($Maqu_Id);
            echo $resultado;
            break;
    }
}
?>
