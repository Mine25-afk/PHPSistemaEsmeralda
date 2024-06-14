<?php
require_once 'config.php';

class JoyasController {
    public function listarJoyas() {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listar`()';
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
            throw new Exception('Error al listar Joyas: ' . $e->getMessage());
        }
    }

    public function insertarJoya($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_insertar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Joya_Nombre'], $data['Joya_PrecioCompra'], $data['Joya_PrecioVenta'], $data['Joya_PrecioMayor'], $data['Joya_Imagen'], $data['Joya_Stock'], $data['Prov_Id'], $data['Mate_Id'], $data['Cate_Id'], $data['Joya_UsuarioCreacion'], $data['Joya_FechaCreacion']
            ]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al insertar Joya: ' . $e->getMessage());
        }
    }

    public function actualizarJoya($data) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_actualizar`(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([
                $data['Joya_Nombre'], $data['Joya_PrecioCompra'], $data['Joya_PrecioVenta'], $data['Joya_PrecioMayor'], $data['Joya_Imagen'], $data['Joya_Stock'], $data['Prov_Id'], $data['Mate_Id'], $data['Cate_Id'], $data['Joya_UsuarioModificacion'], $data['Joya_FechaModificacion'], $data['Joya_Id']
            ]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al actualizar Joya: ' . $e->getMessage());
        }
    }

    public function eliminarJoya($Joya_Id) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_eliminar`(?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([$Joya_Id]);

            return $stmt->fetch();

        } catch (Exception $e) {
            throw new Exception('Error al eliminar Joya: ' . $e->getMessage());
        }
    }

    public function obtenerJoya($Joya_Id) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_buscar`(?)';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute([$Joya_Id]);
            $result = $stmt->fetch();

            if ($result === false) {
                throw new Exception('Error al obtener datos de la joya: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al obtener datos de la joya: ' . $e->getMessage());
        }
    }
}
?>