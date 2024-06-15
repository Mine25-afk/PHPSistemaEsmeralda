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
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Prov_Id' => $row['Prov_Id'],
                    'Prov_Proveedor' => $row['Prov_Proveedor'],
                    'Prov_Telefono' => $row['Prov_Telefono'],
                    'Muni_Municipio' => $row['Muni_Municipio']
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar proveedores: ' . $e->getMessage());
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

    public function actualizarProveedor($Prov_Id, $Prov_Proveedor, $Prov_Telefono, $Muni_Codigo, $Prov_UsuarioModificacion, $Prov_FechaModificacion) {
        try {
            $sql = 'CALL SP_Proveedor_actualizar(:Prov_Id, :Prov_Proveedor, :Prov_Telefono, :Muni_Codigo, :Prov_UsuarioModificacion, :Prov_FechaModificacion)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_Proveedor', $Prov_Proveedor, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Telefono', $Prov_Telefono, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_UsuarioModificacion', $Prov_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_FechaModificacion', $Prov_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar el Proveedor: ' . $e->getMessage());
        }
    }

    public function buscarProveedor($Prov_Id) {
        try {
            $sql = 'CALL SP_Proveedor_buscar(:ProvId_param)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ProvId_param', $Prov_Id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception('Error al buscar el Proveedor: ' . $e->getMessage());
        }
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ProveedoresController($pdo);

    if ($_POST['action'] === 'insertar') {
        $Prov_Proveedor = $_POST['Prov_Proveedor'];
        $Prov_Telefono = $_POST['Prov_Telefono'];
        $Muni_Codigo = $_POST['Muni_Codigo'];
        $Prov_UsuarioCreacion = $_POST['Prov_UsuarioCreacion'];
        $Prov_FechaCreacion = $_POST['Prov_FechaCreacion'];
        
        $resultado = $controller->insertarProveedor($Prov_Proveedor, $Prov_Telefono, $Muni_Codigo, $Prov_UsuarioCreacion, $Prov_FechaCreacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'actualizar') {
        $Prov_Id = $_POST['Prov_Id'];
        $Prov_Proveedor = $_POST['Prov_Proveedor'];
        $Prov_Telefono = $_POST['Prov_Telefono'];
        $Muni_Codigo = $_POST['Muni_Codigo'];
        $Prov_UsuarioModificacion = $_POST['Prov_UsuarioModificacion'];
        $Prov_FechaModificacion = $_POST['Prov_FechaModificacion'];

        $resultado = $controller->actualizarProveedor($Prov_Id, $Prov_Proveedor, $Prov_Telefono, $Muni_Codigo, $Prov_UsuarioModificacion, $Prov_FechaModificacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarProveedores') {
        $controller->listarProveedores();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'buscar') {
    $controller = new ProveedoresController($pdo);

    $Prov_Id = $_GET['Prov_Id'];
    $resultado = $controller->buscarProveedor($Prov_Id);
    echo json_encode($resultado);
}
?>
