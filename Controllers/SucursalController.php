<?php
require_once 'config.php';

class SucursalController {
    public function listarSucursals() {
        global $pdo;

    

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Sucursales_Listar`()';
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
            throw new Exception('Error al listar sucursales: ' . $e->getMessage());
        }
    }
}
?>