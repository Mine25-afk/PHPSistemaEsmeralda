<?php
require_once __DIR__ . '/../config.php';

class ProveedoresController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarProveedores() {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Proveedor_listar`()';
            $stmt = $this->pdo->prepare($sql);

            if ($stmt === false) {
                throw new PDOException('Error al preparar la declaración: ' . implode(", ", $this->pdo->errorInfo()));
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            if ($result === false) {
                throw new PDOException('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (PDOException $e) {
            throw new Exception('Error al listar los Proveedores: ' . $e->getMessage());
        }
    }

    public function insertarProveedor($Prov_Proveedor, $Prov_Telefono, $Muni_Codigo, $Prov_UsuarioCreacion, $Prov_FechaCreacion) {
        try {
            $sql = 'CALL SP_Proveedores_insertar(:Prov_Proveedor, :Prov_Telefono, :Muni_Codigo, :Prov_UsuarioCreacion, :Prov_FechaCreacion)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Prov_Proveedor', $Prov_Proveedor, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Telefono', $Prov_Telefono, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_UsuarioCreacion', $Prov_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_FechaCreacion', $Prov_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al insertar el Proveedor: ' . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new ProveedoresController($pdo);

    if ($_POST['action'] === 'insertar') {
        $Prov_Proveedor = $_POST['Prov_Proveedor'];
        $Prov_Telefono = $_POST['Prov_Telefono'];
        $Muni_Codigo = $_POST['Muni_Codigo'];
        $Prov_UsuarioCreacion = $_POST['Prov_UsuarioCreacion'];
        $Prov_FechaCreacion = $_POST['Prov_FechaCreacion'];
        
        $resultado = $controller->insertarProveedor($Prov_Proveedor, $Prov_Telefono, $Muni_Codigo, $Prov_UsuarioCreacion, $Prov_FechaCreacion);
        echo $resultado;
    }
}
