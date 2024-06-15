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

    public function insertarEmpleado($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleados_insertar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Nombres'], 
                $data['Apellidos'], 
                $data['Sexo'], 
                $data['FechaNac'], 
                $data['DNI'], 
                $data['Municipio'], 
                $data['Sucursal'], 
                $data['EstadoCivil'], 
                $data['Cargo'], 
                $data['Correo'], 
                1, // Empl_UsuarioCreacion (por ejemplo, el ID del usuario actual)
                date('Y-m-d H:i:s') // Empl_FechaCreacion (fecha actual)
            ]);

            return true;

        } catch (Exception $e) {
            throw new Exception('Error al insertar empleado: ' . $e->getMessage());
        }
    }
}
?>
