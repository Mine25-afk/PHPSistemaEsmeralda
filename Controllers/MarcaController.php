<?php
require_once 'config.php';

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
            throw new Exception('Error al listar facturas: ' . $e->getMessage());
        }
    }
}
?>