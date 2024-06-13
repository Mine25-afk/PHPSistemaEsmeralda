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

    public function crearJoya($joya) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_crear`(:nombre, :precioCompra, :precioVenta, :stock, :precioMayor, :imagen, :material, :proveedor, :categoria)';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':nombre', $joya['nombre']);
            $stmt->bindParam(':precioCompra', $joya['precioCompra']);
            $stmt->bindParam(':precioVenta', $joya['precioVenta']);
            $stmt->bindParam(':stock', $joya['stock']);
            $stmt->bindParam(':precioMayor', $joya['precioMayor']);
            $stmt->bindParam(':imagen', $joya['imagen']);
            $stmt->bindParam(':material', $joya['material']);
            $stmt->bindParam(':proveedor', $joya['proveedor']);
            $stmt->bindParam(':categoria', $joya['categoria']);

            $stmt->execute();

        } catch (Exception $e) {
            throw new Exception('Error al crear Joya: ' . $e->getMessage());
        }
    }

    public function actualizarJoya($id, $joya) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_actualizar`(:id, :nombre, :precioCompra, :precioVenta, :stock, :precioMayor, :imagen, :material, :proveedor, :categoria)';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $joya['nombre']);
            $stmt->bindParam(':precioCompra', $joya['precioCompra']);
            $stmt->bindParam(':precioVenta', $joya['precioVenta']);
            $stmt->bindParam(':stock', $joya['stock']);
            $stmt->bindParam(':precioMayor', $joya['precioMayor']);
            $stmt->bindParam(':imagen', $joya['imagen']);
            $stmt->bindParam(':material', $joya['material']);
            $stmt->bindParam(':proveedor', $joya['proveedor']);
            $stmt->bindParam(':categoria', $joya['categoria']);

            $stmt->execute();

        } catch (Exception $e) {
            throw new Exception('Error al actualizar Joya: ' . $e->getMessage());
        }
    }

    public function eliminarJoya($id) {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_eliminar`(:id)';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':id', $id);

            $stmt->execute();

        } catch (Exception $e) {
            throw new Exception('Error al eliminar Joya: ' . $e->getMessage());
        }
    }

}
?>