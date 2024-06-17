<?php
require_once __DIR__ . '/../config.php';

class FacturaController {
    public function listarFactura() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Factura_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $confirmar = $row['Fact_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-confirmar'><i class='fas fa-eraser'></i> Confirmar</button>" : "";
                $editar = $row['Fact_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</button>" : "";
                $detalles = $row['Fact_Finalizado'] == 0 ? "<button style='margin: 0 5px;' class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i>Detalles</button>" : "";
                $acciones = "<div class='text-center'>" . $detalles . $editar . $confirmar . "</div>";
                $data[] = array(
                    'Fact_Id' => $row['Fact_Id'],
                    'Clie_Nombre'=> $row['Clie_Nombre'],
                    'Empl_Nombre'=> $row['Empl_Nombre'],
                    'Mepa_Metodo'=> $row['Mepa_Metodo'],
                    'Fact_Finalizado'=> $row['Fact_Finalizado'],
                    'Acciones' => $acciones
                );
            }
            echo json_encode(array('data' => $data));

        } catch (Exception $e) {
            throw new Exception('Error al listar facturas: ' . $e->getMessage());
        }
    }

    public function ConfirmarFactura($Fact_Codigo, $Fact_FechaFinalizado,$Fact_Pago, $Fact_Cambio) {
        global $pdo;
        try {
            $sql = 'CALL sp_ConfirmarFactura(:Fact_Codigo,:Fact_FechaFinalizado,:Fact_Pago,:Fact_Cambio)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Fact_FechaFinalizado',$Fact_FechaFinalizado, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Pago', $Fact_Pago, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Cambio', $Fact_Cambio, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new FacturaController();

    if ($_POST['action'] === 'listarFactura') {
        $controller->listarFactura();
    } elseif ($_POST['action'] === 'confirmar') {
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Fact_FechaFinalizado = $_POST['Fact_FechaFinalizado'];
        $Fact_Pago = $_POST['Fact_Pago'];
        $Fact_Cambio = $_POST['Fact_Cambio'];
        
        $resultado = $controller->ConfirmarFactura($Fact_Codigo,$Fact_FechaFinalizado, $Fact_Pago, $Fact_Cambio);
        echo $resultado;
    }
}
?>