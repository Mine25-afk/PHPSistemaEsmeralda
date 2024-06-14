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
            throw new Exception('Error al listar marcas: ' . $e->getMessage());
        }
    }

    public function insertarMarca($nombre) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Marcas_insertar`(:nombre, 1, :fecha)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha', date('Y-m-d')); // Puedes ajustar la fecha según sea necesario
            $stmt->execute();

            $result = $stmt->fetch();
            return $result['result']; // Suponiendo que el SP devuelve un campo "result"
        } catch (Exception $e) {
            throw new Exception('Error al insertar marca: ' . $e->getMessage());
        }
    }


}

?>