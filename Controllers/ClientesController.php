<?php
require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');
class ClientesController {

    public function listarClientes() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Clientes_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $dniList = array_column($result, 'Clie_DNI');
            echo json_encode($dniList);
        } catch (Exception $e) {
            error_log('Error al listar clientes: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar clientes: ' . $e->getMessage()));
        }
    }

    public function listarMunicipios() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Municipio_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar municipios: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar municipios: ' . $e->getMessage()));
        }
    }

    public function listarEstadosCiviles() {
        global $pdo;
        try {
            $sql = 'CALL `sp_EstadosCiviles_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar estados civiles: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar estados civiles: ' . $e->getMessage()));
        }
    }

    public function listarCorreosAdministradores($enviarCorreo = false) {
        global $pdo;
        try {
            $sql = 'CALL SP_Empleados_CorreosAdministradores()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $codigosTemporales = array();

          
           
        
            echo json_encode(array('data' => $result, 'codigos_temporales' => $codigosTemporales));
        } catch (PDOException $e) {
            error_log('Error al listar correos de administradores: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar correos de administradores'));
        } catch (Exception $e) {
            error_log('Error general al listar correos de administradores: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error general al listar correos de administradores'));
        }
    }
    
    

    public function insertarClientes($Clie_Nombre, $Clie_Apellido, $Clie_FechaNac, $Clie_Sexo, $Clie_DNI, $Muni_Codigo, $Esta_Id, $Clie_UsuarioCreacion, $Clie_FechaCreacion, $Clie_esMayorista) {
        global $pdo;
        try {
            $sql = 'CALL SP_Clientes_insertar(:Clie_Nombre, :Clie_Apellido, :Clie_FechaNac, :Clie_Sexo, :Clie_DNI, :Muni_Codigo, :Esta_Id, :Clie_UsuarioCreacion, :Clie_FechaCreacion, :Clie_esMayorista)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Nombre', $Clie_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_Apellido', $Clie_Apellido, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_FechaNac', $Clie_FechaNac, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_Sexo', $Clie_Sexo, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_DNI', $Clie_DNI, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Esta_Id', $Esta_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Clie_UsuarioCreacion', $Clie_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Clie_FechaCreacion', $Clie_FechaCreacion, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_esMayorista', $Clie_esMayorista, PDO::PARAM_BOOL);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar cliente: ' . $e->getMessage());
            return 0; 
        }
    }

    public function actualizarClientes($Clie_Nombre, $Clie_Apellido, $Clie_FechaNac, $Clie_Sexo, $Clie_DNI, $Muni_Codigo, $Esta_Id, $Clie_UsuarioModificacion, $Clie_FechaModificacion, $Clie_Id, $Clie_esMayorista) {
        global $pdo;
        try {
            $sql = 'CALL SP_Clientes_actualizar(:Clie_Nombre, :Clie_Apellido, :Clie_FechaNac, :Clie_Sexo, :Clie_DNI, :Muni_Codigo, :Esta_Id, :Clie_UsuarioModificacion, :Clie_FechaModificacion, :Clie_Id, :Clie_esMayorista)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Nombre', $Clie_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_Apellido', $Clie_Apellido, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_FechaNac', $Clie_FechaNac, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_Sexo', $Clie_Sexo, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_DNI', $Clie_DNI, PDO::PARAM_STR);
            $stmt->bindParam(':Muni_Codigo', $Muni_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Esta_Id', $Esta_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Clie_UsuarioModificacion', $Clie_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Clie_FechaModificacion', $Clie_FechaModificacion, PDO::PARAM_STR);
            $stmt->bindParam(':Clie_Id', $Clie_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Clie_esMayorista', $Clie_esMayorista, PDO::PARAM_BOOL);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al actualizar cliente: ' . $e->getMessage());
            return 0;
        }
    }

    public function eliminarClientes($Clie_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Clientes_eliminar(:Clie_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Id', $Clie_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar cliente: ' . $e->getMessage());
            return 0;
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ClientesController();

    switch ($_POST['action']) {
        case 'listarClientes':
            $controller->listarClientes();
            break;
        case 'listarMunicipios':
            $controller->listarMunicipios();
            break;
        case 'listarEstadosCiviles':
            $controller->listarEstadosCiviles();
            break;
        case 'insertar':
            $Clie_Nombre = $_POST['Clie_Nombre'];
            $Clie_Apellido = $_POST['Clie_Apellido'];
            $Clie_FechaNac = $_POST['Clie_FechaNac'];
            $Clie_Sexo = $_POST['Clie_Sexo'];
            $Clie_DNI = $_POST['Clie_DNI'];
            $Muni_Codigo = $_POST['Muni_Codigo'];
            $Esta_Id = $_POST['Esta_Id'];
            $Clie_UsuarioCreacion = $_POST['Clie_UsuarioCreacion'];
            $Clie_FechaCreacion = $_POST['Clie_FechaCreacion'];
            $Clie_esMayorista = $_POST['Clie_esMayorista'] === "true" ? 1 : 0; // Convertir a 1 o 0 para almacenar en la base de datos


            $resultado = $controller->insertarClientes($Clie_Nombre, $Clie_Apellido, $Clie_FechaNac, $Clie_Sexo, $Clie_DNI, $Muni_Codigo, $Esta_Id, $Clie_UsuarioCreacion, $Clie_FechaCreacion, $Clie_esMayorista);
            echo json_encode(array('result' => $resultado));
            break;
        case 'actualizar':
            $Clie_Nombre = $_POST['Clie_Nombre'];
            $Clie_Apellido = $_POST['Clie_Apellido'];
            $Clie_FechaNac = $_POST['Clie_FechaNac'];
            $Clie_Sexo = $_POST['Clie_Sexo'];
            $Clie_DNI = $_POST['Clie_DNI'];
            $Muni_Codigo = $_POST['Muni_Codigo'];
            $Esta_Id = $_POST['Esta_Id'];
            $Clie_UsuarioModificacion = $_POST['Clie_UsuarioModificacion'];
            $Clie_FechaModificacion = $_POST['Clie_FechaModificacion'];
            $Clie_Id = $_POST['Clie_Id'];
            $Clie_esMayorista = $_POST['Clie_esMayorista'] === "true" ? 1 : 0; // Convertir a 1 o 0 para almacenar en la base de datos


            $resultado = $controller->actualizarClientes($Clie_Nombre, $Clie_Apellido, $Clie_FechaNac, $Clie_Sexo, $Clie_DNI, $Muni_Codigo, $Esta_Id, $Clie_UsuarioModificacion, $Clie_FechaModificacion, $Clie_Id, $Clie_esMayorista);
            echo json_encode(array('result' => $resultado));
            break;
        case 'eliminar':
            $Clie_Id = $_POST['Clie_Id'];
            $resultado = $controller->eliminarClientes($Clie_Id);
            echo json_encode(array('result' => $resultado));
            break;
    }
}
?>
