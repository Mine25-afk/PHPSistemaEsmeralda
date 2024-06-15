<?php
require_once 'config.php';

class MunicipioController {
    public function listarMunicipiosPorDepartamento($Depa_Codigo) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Municipios_MostrarPorDepartamento`(?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([$Depa_Codigo]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar municipios: ' . $e->getMessage());
        }
    }
}
?>
