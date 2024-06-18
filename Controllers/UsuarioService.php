<?php
require_once __DIR__ . '/../config.php';
session_start();

class UsuarioService
{
    public function listarUsuarios()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Usuario_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Usua_Id' => $row['Usua_Id'],
                    'Usua_Usuario' => $row['Usua_Usuario'],
                    'Usua_Administrador' => $row['Usua_Administradores'],
                    'Empleado' => $row['Empleado'],
                    'Role_Rol' => $row['Role_Rol'],
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            error_log('Error al listar usuarios: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar usuarios: ' . $e->getMessage()));
        }
    }

    public function listarEmpleados()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Empleado_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('listarEmpleados Response: ' . json_encode($result));
            return json_encode($result);
        } catch (Exception $e) {
            error_log('Error al listar empleados: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar empleados: ' . $e->getMessage()));
        }
    }

    public function listarRoles()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Roles_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('listarRoles Response: ' . json_encode($result));
            return json_encode($result);
        } catch (Exception $e) {
            error_log('Error al listar roles: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar roles: ' . $e->getMessage()));
        }
    }

    public function insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion)
{
    global $pdo;
    try {
        $sql = 'CALL `dbsistemaesmeralda`.`SP_Usuario_insertar`(:Usua_Usuario, :Usua_Contraseña, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioCreacion, :Usua_FechaCreacion)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
        $stmt->bindParam(':Usua_Contraseña', $Usua_Contraseña, PDO::PARAM_STR);
        $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_INT);
        $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
        $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
        $stmt->bindParam(':Usua_UsuarioCreacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
        $stmt->bindParam(':Usua_FechaCreacion', $Usua_FechaCreacion, PDO::PARAM_STR);

        error_log("Ejecutando consulta: $sql con parámetros Usua_Usuario=$Usua_Usuario, Usua_Contraseña=$Usua_Contraseña, Usua_Administrador=$Usua_Administrador, Empl_Id=$Empl_Id, Role_Id=$Role_Id, Usua_UsuarioCreacion=$Usua_UsuarioCreacion, Usua_FechaCreacion=$Usua_FechaCreacion");

        $stmt->execute();
        $result = $stmt->fetchColumn();
        error_log('insertarUsuario Response: ' . $result);
        return $result;
    } catch (PDOException $e) {
        error_log('Error al insertar usuario: ' . $e->getMessage());
        return 'Error: ' . $e->getMessage();
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
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioModificacion', $Usua_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaModificacion', $Usua_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            error_log('actualizarUsuario Response: ' . $result);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al actualizar usuario: ' . $e->getMessage());
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
            error_log('eliminarUsuario Response: ' . $result);
            return $result;
        } catch (PDOException $e) {
            error_log('Error al eliminar usuario: ' . $e->getMessage());
            return 0;
        }
    }

    public function buscarUsuarioPorId($Usua_Id)
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Usuarios_Buscar`(:Usua_Id)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Usua_Id', $Usua_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al buscar usuario: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al buscar usuario: ' . $e->getMessage()));
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $Service = new UsuarioService();

    if ($_POST['action'] === 'listarUsuarios') {
        $service->listarUsuarios();
    } elseif ($_POST['action'] === 'insertar') {
        $Usua_Usuario = $_POST['Usuario'];
        $Usua_Contraseña = $_POST['Contraseña'];
        $Usua_Administrador = isset($_POST['Administrador']);
        $Empl_Id = $_POST['Empleado'];
        $Role_Id = $_POST['Rol'];
        $Usua_UsuarioCreacion = $_SESSION['Usua_Id'];
        $Usua_FechaCreacion = (new DateTime())->format('Y-m-d H:i:s');

        error_log('Datos recibidos en insertar: ' . json_encode(compact('Usua_Usuario', 'Usua_Contraseña', 'Usua_Administrador', 'Empl_Id', 'Role_Id', 'Usua_UsuarioCreacion', 'Usua_FechaCreacion')));

        $resultado = $service->insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'actualizar') {
        $Usua_Id = $_POST['Usua_Id'];
        if (empty($Usua_Id)) {
            error_log('Usua_Id está vacío en actualizar');
        }
        $Usua_Usuario = $_POST['Usuario'];
        $Usua_Administrador = isset($_POST['Administrador']) ? 1 : 0;
        $Empl_Id = $_POST['Empleado'];
        $Role_Id = $_POST['Rol'];
        $Usua_UsuarioModificacion = $_SESSION['Usua_Id'];
        $Usua_FechaModificacion = (new DateTime())->format('Y-m-d H:i:s');

        $resultado = $service->actualizarUsuario($Usua_Id, $Usua_Usuario, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioModificacion, $Usua_FechaModificacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'eliminar') {
        $Usua_Id = $_POST['Usua_Id'];
        if (empty($Usua_Id)) {
            error_log('Usua_Id está vacío en eliminar');
        }
        $resultado = $service->eliminarUsuario($Usua_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'buscar') {
        $Usua_Id = $_POST['Usua_Id'];
        $resultado = $service->buscarUsuarioPorId($Usua_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarRoles') {
        echo $service->listarRoles();
    } elseif ($_POST['action'] === 'listarEmpleados') {
        echo $service->listarEmpleados();
    }
}
?>
