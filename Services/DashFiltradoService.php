<?php
require_once __DIR__ . '/../config.php';

class DashboardFiltradossServices {




    public function cantidadComprasFiltro($fecha_inicio, $fecha_fin) {
        global $pdo;
    
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Dash_CantidadProducto_RangoFechas`(?, ?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }
    
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }
    
            return $result;
    
        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }
    
    public function cantidadVentasFiltro($fecha_inicio, $fecha_fin) {
        global $pdo;
    
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_TotalFinal_JoyasMes`(?, ?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }
    
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }
    
            return $result;
    
        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }
    
    public function cantidadVentasEmpleadosFiltro($fecha_inicio, $fecha_fin) {
        global $pdo;
    
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_VentasPorMetodoPago`(?, ?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }
    
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }
    
            return $result;
    
        } catch (Exception $e) {
            throw new Exception('Error al listar: ' . $e->getMessage());
        }
    }
    
    public function cantidadComprasClientesFiltro($fecha_inicio, $fecha_fin) {
        global $pdo;
    
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_DashGeneroMes`(?, ?)';
            $stmt = $pdo->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }
    
            $stmt->execute([$fecha_inicio, $fecha_fin]);
            
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
