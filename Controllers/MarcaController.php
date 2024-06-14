<?php
require_once __DIR__ . '/../config.php';

class MarcaController {
    public function listarMarcas() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Marcas_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar marcas: ' . $e->getMessage());
        }
    }

    public function insertarMarca($Marc_Marca, $Marc_UsuarioCreacion, $Marc_FechaCreacion) {
        global $pdo;
        try {
            $sql = 'CALL sp_Marcas_insertar(:Marc_Marca, :Marc_UsuarioCreacion, :Marc_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Marc_Marca', $Marc_Marca, PDO::PARAM_STR);
            $stmt->bindParam(':Marc_UsuarioCreacion', $Marc_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Marc_FechaCreacion', $Marc_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new MarcaController();

    if ($_POST['action'] === 'insertar') {
        $Marc_Marca = $_POST['Marc_Marca'];
        $Marc_UsuarioCreacion = $_POST['Marc_UsuarioCreacion'];
        $Marc_FechaCreacion = $_POST['Marc_FechaCreacion'];
        
        $resultado = $controller->insertarMarca($Marc_Marca, $Marc_UsuarioCreacion, $Marc_FechaCreacion);
        echo $resultado;
    }
}

?>