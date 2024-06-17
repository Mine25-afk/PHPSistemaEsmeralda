<?php
require_once __DIR__ . '/../config.php';
session_start();

class FacturaCompraController
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
                $data[] = array(
                    'FaCE_Id'=> $row['FaCE_Id'],
                    'nombreProveedor' => $row['nombreProveedor'],
                    'mepa_Metodo' => $row['mepa_Metodo']
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar la factura de compra: ' . $e->getMessage());
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new FacturaCompraController();

    if ($_POST['action'] === 'listarFacturaCompras') {
        $controller->listarFacturaCompras();
    } elseif ($_POST['action'] === 'buscar') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $resultado = $controller->buscarFacturaCompraPorCodigo($FaCE_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarProveedores') {
        echo $controller->listarProveedores();
    } elseif ($_POST['action'] === 'listarSucursales') {
        echo $controller->listarSucursales();
    } 
}
