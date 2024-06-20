<?php
require_once __DIR__ . '/../config.php';
session_start(); 

class ReportesServices {

    public function ReporteVentasPorMetodoPago($mepaId) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_ReporteVentaspPorPago`(?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$mepaId]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al obtener datos: ' . $e->getMessage());
        }
    }

    public function listarMetodosPago() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_MetodosPago_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al listar métodos de pago: ' . $e->getMessage());
        }
    }

    public function ReporteControlStock($tipoProducto, $sucuId) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Reporte_ControlStock`(?, ?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$tipoProducto, $sucuId]);
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $e) {
            throw new Exception('Error al obtener datos: ' . $e->getMessage());
        }
    }

    public function listarSucursales() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Sucursales_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Sucu_Id' => $row['Sucu_Id'],
                    'Sucu_Nombre' => $row['Sucu_Nombre']
                );
            }
    
            return json_encode(['status' => 'success', 'data' => $data]);
        } catch (Exception $e) {
            return json_encode(['status' => 'error', 'message' => 'Error al listar sucursales: ' . $e->getMessage()]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'reportedemetodopago' && isset($_POST['Mepa_Id'])) {
        $mepaId = $_POST['Mepa_Id'];
        try {
            $reportService = new ReportesServices();
            $resultado = $reportService->ReporteVentasPorMetodoPago($mepaId);
            echo json_encode(['status' => 'success', 'data' => $resultado]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'listarmetodospago') {
        try {
            $reportService = new ReportesServices();
            $resultado = $reportService->listarMetodosPago();
            echo json_encode(['status' => 'success', 'data' => $resultado]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'reportecontrolstock' && isset($_POST['TipoProducto']) && isset($_POST['Sucu_Id'])) {
        $tipoProducto = $_POST['TipoProducto'];
        $sucuId = $_POST['Sucu_Id'];
        try {
            $reportService = new ReportesServices();
            $resultado = $reportService->ReporteControlStock($tipoProducto, $sucuId);
            echo json_encode(['status' => 'success', 'data' => $resultado]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'listarsucursales') {
        try {
            $reportService = new ReportesServices();
            $resultado = $reportService->listarSucursales();
            echo $resultado; // JSON response
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parámetros inválidos']);
    }
}
?>
