<?php
require_once __DIR__ . '/../config.php';
session_start();

class UsuarioController
{
    public function listarUsuarios()
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuario_Listar()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Usua_Usuario' => $row['Usua_Usuario'],
                    'Usua_Administrador' => $row['Usua_Administradores'],
                    'Empleado' => $row['Empleado'],
                    'Role_Rol' => $row['Role_Rol'],
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar usuarios: ' . $e->getMessage());
        }
    }

    public function insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuario_insertar(:Usua_Usuario, :Usua_Contraseña, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioCreacion, :Usua_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Contraseña', $Usua_Contraseña, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_BOOL);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioCreacion', $Usua_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaCreacion', $Usua_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function listarEmpleados()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleado_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar sucursales: ' . $e->getMessage());
        }
    }
    public function listarRoles()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Roles_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            throw new Exception('Error al listar estadosciviles: ' . $e->getMessage());
        }
    }

    public function actualizarUsuario($Usua_Id, $Usua_Usuario, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioModificacion, $Usua_FechaModificacion)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Actualizar(:Usua_Id, :Usua_Usuario, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioModificacion, :Usua_FechaModificacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_BOOL);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioModificacion', $Usua_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaModificacion', $Usua_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function eliminarUsuario($Usua_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Eliminar(:Usua_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function buscarUsuarioPorId($Usua_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_Buscar(:Usua_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar el usuario: ' . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new UsuarioController();

    if ($_POST['action'] === 'listarUsuarios') {
        $controller->listarUsuarios();
    } elseif ($_POST['action'] === 'insertar') {
        $Usua_Usuario = $_POST['Usuario'];
        $Usua_Contraseña = $_POST['Contraseña'];
        $Usua_Administrador = isset($_POST['Administrador']) ? 1 : 0;
        $Empl_Id = $_POST['Empleado'];
        $Role_Id = $_POST['Rol'];
        $Usua_UsuarioCreacion = $_SESSION['Usua_Id'];
        $Usua_FechaCreacion = (new DateTime())->format('Y-m-d H:i:s');

        $resultado = $controller->insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'actualizar') {
        $Usua_Id = $_POST['Usua_Id'];
        $Usua_Usuario = $_POST['Usuario'];
        $Usua_Administrador = isset($_POST['Administrador']) ? 1 : 0;
        $Empl_Id = $_POST['Empleado'];
        $Role_Id = $_POST['Rol'];
        $Usua_UsuarioModificacion = $_SESSION['Usua_Id'];
        $Usua_FechaModificacion = (new DateTime())->format('Y-m-d H:i:s');

        $resultado = $controller->actualizarUsuario($Usua_Id, $Usua_Usuario, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioModificacion, $Usua_FechaModificacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'eliminar') {
        $Usua_Id = $_POST['Usua_Id'];
        $resultado = $controller->eliminarUsuario($Usua_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'buscar') {
        $Usua_Id = $_POST['Usua_Id'];
        $resultado = $controller->buscarUsuarioPorId($Usua_Id);
        echo $resultado;
    }elseif ($_POST['action'] === 'listarRoles') {
        echo $controller->listarRoles();
    } elseif ($_POST['action'] === 'listarEmpleados') {
        echo $controller->listarEmpleados();
    } 
}
?>
