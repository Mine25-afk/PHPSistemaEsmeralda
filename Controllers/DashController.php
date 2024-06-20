<?php
require_once __DIR__ . '/../config.php';

class DashController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function VentasDelMes() {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Ventas_Del_Mes`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result); // Convertir a JSON antes de devolver
        } catch (Exception $e) {
            error_log('Error al listar ventas del mes: ' . $e->getMessage());
            throw new Exception('Error al listar ventas del mes: ' . $e->getMessage());
        }
    }

    public function ComprasDelMes() {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Ventas_Del_Mes_FacturaCompra`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result); // Convertir a JSON antes de devolver
        } catch (Exception $e) {
            error_log('Error al listar compras del mes: ' . $e->getMessage());
            throw new Exception('Error al listar compras del mes: ' . $e->getMessage());
        }
    }

    public function ProductosvendidoDelmes() {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Productos_Del_Mes`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result); // Convertir a JSON antes de devolver
        } catch (Exception $e) {
            error_log('Error al listar productos vendidos del mes: ' . $e->getMessage());
            throw new Exception('Error al listar productos vendidos del mes: ' . $e->getMessage());
        }
    }
}
?>
