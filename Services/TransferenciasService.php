<?php
require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');

class TransferenciasServices
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function respond($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    private function handleException($e, $message)
    {
        error_log($message . ': ' . $e->getMessage());
        $this->respond(['error' => $message . ': ' . $e->getMessage()]);
    }

    public function obtenerProductosPorSucursales()
    {
        try {
            $sql = 'CALL SP_ObtenerProductosPorSucursales()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->respond(['data' => $result]);
        } catch (Exception $e) {
            $this->handleException($e, 'Error al obtener productos por sucursales');
        }
    }

    public function listarSucursales()
    {
        try {
            $sql = 'CALL sp_Sucursales_Listar()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->respond($result);
        } catch (Exception $e) {
            $this->handleException($e, 'Error al listar sucursales');
        }
    }

    public function obtenerProductosPorCodigo($codigo)
    {
        try {
            $sql = 'CALL SP_ObtenerProductosPorSucursalesPorCodigo(:Codigo)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->respond(['data' => $result]);
        } catch (Exception $e) {
            $this->handleException($e, 'Error al obtener productos por código');
        }
    }

    public function obtenerProductosPorCodigoDropdownlist($Sucu_Id)
    {
        try {
            $sql = 'CALL SP_ObtenerProductosPorSucursalesDropdownList(:Sucu_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Sucu_Id', $Sucu_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->respond(['data' => $result]);
        } catch (Exception $e) {
            $this->handleException($e, 'Error al obtener productos por sucursal');
        }
    }

    public function transferirProductos($Prxs_Dif_, $Prod_Nombre_, $Prsx_Stock_, $Sucu_EnviadoId_, $Sucu_RecibidoId_)
    {
        header('Content-Type: application/json');
        try {
            // Desactivar SQL_SAFE_UPDATES
            $this->pdo->exec('SET SQL_SAFE_UPDATES = 0;');

            // Llamar al procedimiento almacenado
            $sql = 'CALL SP_ProductosPorSucursales_Transferir(:Prxs_Dif_, :Prod_Nombre_, :Prsx_Stock_, :Sucu_EnviadoId_, :Sucu_RecibidoId_)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Prxs_Dif_', $Prxs_Dif_, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre_', $Prod_Nombre_, PDO::PARAM_STR);
            $stmt->bindParam(':Prsx_Stock_', $Prsx_Stock_, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_EnviadoId_', $Sucu_EnviadoId_, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_RecibidoId_', $Sucu_RecibidoId_, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();

            // Reactivar SQL_SAFE_UPDATES
            $this->pdo->exec('SET SQL_SAFE_UPDATES = 1;');


            $this->respond(['result' => $result]);
        } catch (Exception $e) {
            http_response_code(500); // Establece el código de estado HTTP adecuado
            echo json_encode(['error' => 'Descripción del error']);
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new TransferenciasServices($pdo);

    switch ($_POST['action']) {
        case 'obtenerProductosPorSucursales':
            $controller->obtenerProductosPorSucursales();
            break;
        case 'listarSucursales':
            $controller->listarSucursales();
            break;
        case 'obtenerProductosPorCodigo':
            if (isset($_POST['Codigo'])) {
                $codigo = $_POST['Codigo'];
                $controller->obtenerProductosPorCodigo($codigo);
            } else {
                $controller->respond(['error' => 'Codigo no proporcionado']);
            }
            break;
        case 'obtenerProductosPorCodigoDropdownlist':
            if (isset($_POST['Sucu_Id'])) {
                $Sucu_Id = $_POST['Sucu_Id'];
                $controller->obtenerProductosPorCodigoDropdownlist($Sucu_Id);
            } else {
                $controller->respond(['error' => 'Sucu_Id no proporcionado']);
            }
            break;
        case 'transferir':
            if (isset($_POST['Prxs_Dif_'], $_POST['Prod_Nombre_'], $_POST['Prsx_Stock_'], $_POST['Sucu_EnviadoId_'], $_POST['Sucu_RecibidoId_'])) {
                $Prxs_Dif_ = $_POST['Prxs_Dif_'];
                $Prod_Nombre_ = $_POST['Prod_Nombre_'];
                $Prsx_Stock_ = $_POST['Prsx_Stock_'];
                $Sucu_EnviadoId_ = $_POST['Sucu_EnviadoId_'];
                $Sucu_RecibidoId_ = $_POST['Sucu_RecibidoId_'];
                $controller->transferirProductos($Prxs_Dif_, $Prod_Nombre_, $Prsx_Stock_, $Sucu_EnviadoId_, $Sucu_RecibidoId_);
            } else {
                $controller->respond(['error' => 'Parámetros incompletos']);
            }
            break;
        default:
            $controller->respond(['error' => 'Acción no válida']);
            break;
    }
}
