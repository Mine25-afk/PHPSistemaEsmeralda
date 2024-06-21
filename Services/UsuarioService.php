<?php
require_once __DIR__ . '/../config.php';
session_start();

class UsuarioService
{
    public function listarUsuarios() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Usuario_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar clientes: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar clientes: ' . $e->getMessage()));
        }
    }



    public function listarRoles() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Roles_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar estados civiles: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar ROles: ' . $e->getMessage()));
        }
    }

    public function listarEmpleados() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Empleado_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al empleado: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar ROles: ' . $e->getMessage()));
        }
    }

    public function insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion) {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuario_insertar(:Usua_Usuario, :Usua_Contraseña, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioCreacion, :Usua_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Contraseña', $Usua_Contraseña, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioCreacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaCreacion', $Usua_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar Usuario: ' . $e->getMessage());
            return 0; 
        }
    }

    public function actualizarUsuario($Usua_Id, $Usua_Usuario, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioModificacion, $Usua_FechaModificacion) {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Actualizar(:Usua_Id, :Usua_Usuario, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioModificacion, :Usua_FechaModificacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioModificacion', $Usua_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaModificacion', $Usua_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar Usuario: ' . $e->getMessage());
            return 0; 
        }
    }





    public function eliminarUsuario($Usua_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Eliminar(:Usua_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar Usuario: ' . $e->getMessage());
            return 0;
        }
    }



    public function buscarUsuarioPorId($Usua_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Buscar(:Usua_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al buscar USuario: ' . $e->getMessage());
            return null;
        }
    }
    
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new UsuarioService();

    switch ($_POST['action']) {
        case 'listarUsuarios':
            $controller->listarUsuarios();
            break;
        case 'listarRoles':
            $controller->listarRoles();
            break;
            case 'listarEmpleados':
                $controller->listarEmpleados();
                break;
       
        case 'insertar':
            $Usua_Usuario = $_POST['Usua_Usuario'];
            $Usua_Contraseña = $_POST['Usua_Contraseña'];
            $Usua_Administrador = $_POST['Usua_Administrador'];
            $Empl_Id = $_POST['Empl_Id'];
            $Role_Id = $_POST['Role_Id'];
            $Usua_UsuarioCreacion = $_FILES['Usua_UsuarioCreacion'];
            $Usua_FechaCreacion = $_POST['Usua_FechaCreacion'];
          

            $resultado = $controller->insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion);
            echo json_encode(array('result' => $resultado));
            break;
        case 'actualizar':
            $Usua_Id = $_POST['Usua_Id'];
            $Usua_Usuario = $_POST['Usua_Usuario'];
            $Usua_Contraseña = $_POST['Usua_Contraseña'];
            $Usua_Administrador = $_POST['Usua_Administrador'];
            $Empl_Id = $_POST['Empl_Id'];
            $Role_Id = $_POST['Role_Id'];
            $Usua_UsuarioCreacion = $_FILES['Usua_UsuarioCreacion'];
            $Usua_FechaCreacion = $_POST['Usua_FechaCreacion'];

            $resultado = $controller->actualizarUsuario($Usua_Id, $Usua_Usuario, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioModificacion, $Usua_FechaModificacion);
            echo json_encode(array('result' => $resultado));
            break;
        case 'eliminar':
            $Usua_Id = $_POST['Usua_Id'];
            $resultado = $controller->eliminarUsuario($Usua_Id);
            echo json_encode(array('result' => $resultado));
            break;
        case 'buscar':
            $Usua_Id = $_POST['Usua_Id'];
            $resultado = $controller->buscarUsuarioPorId($Usua_Id);
            echo json_encode($resultado);
            break;
    }
}
?>
