<?php
require_once 'config.php';

class ProveedoresController {
    public function listarProveedores() {
        global $pdo;

    

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Proveedor_listar`()';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar los Proveedores: ' . $e->getMessage());
        }
    }
    public function insertarProveedor($Prov_Proveedor, $Prov_Telefono, $Muni_Codigo,$Prov_UsuarioCreacion,$Prov_FechaCreacion) {
        global $pdo;
        try {
            $sql = 'CALL SP_Proveedor_insertar(:Prov_Proveedor, :Prov_Telefono, :Muni_Codigo,:Prov_UsuarioCreacion,:Prov_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Prov_Proveedor', $Prov_Proveedor, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_Telefono', $Prov_Telefono, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Prov_UsuarioCreacion', $Prov_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_FechaCreacion', $Prov_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }
   
  
    public function cargarMunicipios() {
        global $pdo;

    

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Municipio_listar`()';
            $stmt = $pdo->prepare($sql);

            if ($stmt === false) {
                throw new Exception('Error al preparar la declaración: ' . implode(", ", $pdo->errorInfo()));
            }

            $stmt->execute();
            $result = $stmt->fetchAll();

            if ($result === false) {
                throw new Exception('Error al obtener resultados: ' . implode(", ", $stmt->errorInfo()));
            }

            return $result;

        } catch (Exception $e) {
            throw new Exception('Error al listar los Proveedores: ' . $e->getMessage());
        }
    }
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new MarcaController();

    if ($_POST['action'] === 'insertar') {
        $Prov_Proveedor = $_POST['Prov_Proveedor'];
        $Prov_Telefono = $_POST['Prov_Telefono'];
        $Muni_Codigo = $_POST['Muni_Codigo'];
        $Prov_UsuarioCreacion = $_POST['Prov_UsuarioCreacion'];
        $Prov_FechaCreacion = $_POST['Prov_FechaCreacion'];
        
        $resultado = $controller->insertarMarca($Prov_Proveedor, $Prov_Telefono, $Muni_Codigo,$Prov_UsuarioCreacion,$Prov_FechaCreacion);
        echo $resultado;
    }
}
?>