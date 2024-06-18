<?php
require_once __DIR__ . '/../config.php';
session_start();

class FacturaCompraService
{
    public function listarFacturaCompras()
{
    global $pdo;
    try {
        $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Listar`()';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data = array();
        foreach ($result as $row) {
            $editar = $row['faCE_Finalizada'] == 'Si' ? "<button style='margin: 0 5px;' class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-pencil-alt'></i> Editar</button>" : "";
            $imprimir = $row['faCE_Finalizada'] == 'No' ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-imprimir' ><i class='fas fa-print'></i> Imprimir</button>" : "";
            $finalizar = $row['faCE_Finalizada'] == 'Si' ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-finalizar'><i class='fas fa-check-circle'></i> Finalizar</button>" : "";
            $acciones = "<div class='text-center'>" . $editar . $imprimir . $finalizar . "</div>";
            $data[] = array(
                'FaCE_Id'=> $row['FaCE_Id'],
                'nombreProveedor' => $row['nombreProveedor'],
                'mepa_Metodo' => $row['mepa_Metodo'],
                'faCE_Finalizada' => $row['faCE_Finalizada'],
                'Acciones' => $acciones
            );
        }
        echo json_encode(array('data' => $data));
    } catch (Exception $e) {
        echo json_encode(array('error' => 'Error al listar la factura de compra: ' . $e->getMessage()));
    }
}
    public function listarSucursales()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Sucursales_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar sucursales: ' . $e->getMessage());
        }
    }
    public function listarProveedores()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Proveedor_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar Proveedores: ' . $e->getMessage());
        }
    }
    public function buscarFacturaCompraPorCodigo($FaCE_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Buscar`(:FaCE_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la factura compra: ' . $e->getMessage());
        }
    }

    public function listarJoyasAutoCompletado($term)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listarAutoCompletado1`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array('error' => 'Error al listar joyas para autocompletado: ' . $e->getMessage()));
        }
    }

    public function listarMaquillajesAutoCompletado($term)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Maquillajes_listarAutoCompletado1`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(array('error' => 'Error al listar maquillajes para autocompletado: ' . $e->getMessage()));
        }
    }

    public function buscarMaquillajePorCodigo($codigo)
{
    global $pdo;
    try {
        $sql = 'CALL `dbsistemaesmeralda`.`SP_Maquillajes_Buscarr`(:codigo)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(array('error' => 'Error al buscar maquillaje por código: ' . $e->getMessage()));
    }
}

public function buscarJoyaPorCodigo($codigo)
{
    global $pdo;
    try {
        $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_Buscarr`(:codigo)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(array('error' => 'Error al buscar joya por código: ' . $e->getMessage()));
    }
}

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $service = new FacturaCompraService();

    if ($_POST['action'] === 'listarFacturaCompras') {
        $service->listarFacturaCompras();
    } elseif ($_POST['action'] === 'buscar') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $resultado = $service->buscarFacturaCompraPorCodigo($FaCE_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarProveedores') {
        echo $service->listarProveedores();
    } elseif ($_POST['action'] === 'listarSucursales') {
        echo $service->listarSucursales();
    } elseif ($_POST['action'] === 'listarJoyasAutoCompletado') {
        $term = $_POST['term'];
        echo $service->listarJoyasAutoCompletado($term);
    } elseif ($_POST['action'] === 'listarMaquillajesAutoCompletado') {
        $term = $_POST['term'];
        echo $service->listarMaquillajesAutoCompletado($term);
    }elseif ($_POST['action'] === 'buscarMaquillajePorCodigo') {
        $codigo = $_POST['codigo'];
        echo $service->buscarMaquillajePorCodigo($codigo);
    } elseif ($_POST['action'] === 'buscarJoyaPorCodigo') {
        $codigo = $_POST['codigo'];
        echo $service->buscarJoyaPorCodigo($codigo);
    }
}
