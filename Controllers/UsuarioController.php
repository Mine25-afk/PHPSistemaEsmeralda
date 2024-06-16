<?php
require_once 'config.php';

class UsuarioController {
    public function listarUsuarios() {
        global $pdo;

        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Usuario_Listar`()';
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
            throw new Exception('Error al listar empleados: ' . $e->getMessage());
        }
    }
    public function insertarUsuario($Usua_Usuario, $Usua_Contraseña, $Usua_Administrador, $Empl_Id, $Role_Id, $Usua_UsuarioCreacion, $Usua_FechaCreacion) {
        global $pdo;
        try {
            
            $sql = 'CALL SP_Usuario_insertar(:Usua_Usuario, :Usua_Contraseña, :Usua_Administrador, :Empl_Id, :Role_Id, :Usua_UsuarioCreacion, :Usua_FechaCreacion)';
            $stmt = $this->$pdo->prepare($sql);
            $stmt->bindParam(':Usua_Usuario', $Usua_Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Contraseña', $Usua_Contraseña, PDO::PARAM_STR);
            $stmt->bindParam(':Usua_Administrador', $Usua_Administrador, PDO::PARAM_STR);
            $stmt->bindParam(':Empl_Id', $Empl_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_UsuarioCreacion', $Usua_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Usua_FechaCreacion', $Usua_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            throw new Exception('Error al insertar el Proveedor: ' . $e->getMessage());
        }
    }
}
?>