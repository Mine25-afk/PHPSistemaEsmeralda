<?php
require_once 'config.php';

class ReparacionController {
    public function listarReparaciones() {
        global $pdo;

    

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Factura_Listar`()';
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
            throw new Exception('Error al listar los Proveedores: ' . $e->getMessage());
        }
    }
    
}
?>