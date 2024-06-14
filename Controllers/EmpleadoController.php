<?php
require_once 'config.php';

class EmpleadoController {
    public function listarEmpleados() {
        global $pdo;

    

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleado_Listar`()';
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
            throw new Exception('Error al listar empleados: ' . $e->getMessage());
        }
    }
}
?>