<?php
require_once __DIR__ . '/../config.php';

class DashboardsServices {


    public function cantidadVentas() {
        global $pdo;

        try {

            $sql = 'CALL `dbsistemaesmeralda`.`SP_Ventas_Del_Mes`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

    public function cantidadProductos() {
        global $pdo;

        try {
            
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Productos_Del_Mes`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

    public function cantidadCompra() {
        global $pdo;

        try {
            
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Ventas_Del_Mes_FacturaCompra`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
           
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

    public function cantidadCompras() {
        global $pdo;

        try {
            
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Compras_Cantidad`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

    public function ClientesActivos() {
        global $pdo;

        try {
            
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Clientes_Nuevos_Activos`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }
    public function top5Joyas() {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Dash_CantidadProducto_anual`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

    public function top5Maquillaje() {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleados_Top5`();';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }

}
?>
