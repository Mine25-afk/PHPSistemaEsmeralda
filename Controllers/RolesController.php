<?php
require_once __DIR__ . '/../config.php';

class RolesController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarRoles() {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Roles_listar`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al listar roles: ' . $e->getMessage());
        }
    }

 
    public function insertarRol($Role_Rol, $Role_UsuarioCreacion, $Role_FechaCreacion) {
        try {
            // Preparar la consulta con el parámetro de salida
            $sql = 'CALL sp_Roles_insertar(:Role_Rol, :Role_UsuarioCreacion, :Role_FechaCreacion, @NuevoId)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Rol', $Role_Rol, PDO::PARAM_STR);
            $stmt->bindParam(':Role_UsuarioCreacion', $Role_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Role_FechaCreacion', $Role_FechaCreacion, PDO::PARAM_STR);
    
            // Ejecutar la consulta
            $stmt->execute();
        
            // Obtener el valor del parámetro de salida @NuevoId
            $stmt = $this->pdo->query("SELECT @NuevoId AS NuevoId");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            $nuevoId = $result['NuevoId'];
        
            return $nuevoId; // Devuelve el nuevo ID del rol
        } catch (PDOException $e) {
            throw new Exception('Error al insertar el rol: ' . $e->getMessage());
        }
    }

    public function actualizarRol($Role_Id, $Role_Rol, $Role_UsuarioModificacion, $Role_FechaModificacion) {
        try {
            $sql = 'CALL sp_Roles_actualizar(:Role_Id, :Role_Rol, :Role_UsuarioModificacion, :Role_FechaModificacion)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Rol', $Role_Rol, PDO::PARAM_STR);
            $stmt->bindParam(':Role_UsuarioModificacion', $Role_UsuarioModificacion, PDO::PARAM_INT);
            $stmt->bindParam(':Role_FechaModificacion', $Role_FechaModificacion, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchColumn(); // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar el rol: ' . $e->getMessage());
        }
    }

    public function buscarRol($Role_Id) {
        try {
            $sql = 'CALL sp_Roles_buscar(:Role_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error al buscar el rol: ' . $e->getMessage());
        }
    }

    public function eliminarRol($Role_Id) {
        try {
            $sql = 'CALL sp_Roles_eliminar(:Role_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn(); // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar el rol: ' . $e->getMessage());
        }
    }

    public function listarPantallasRoles() {
        try {
            $sql = 'CALL sp_PantallasRoles_listar()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (PDOException $e) {
            throw new Exception('Error al listar pantallas por roles: ' . $e->getMessage());
        }
    }


    public function insertarPantallaPorRol($Role_Id, $Pant_Id) {
        try {
            $sql = 'INSERT INTO acce_tbpantallasporroles (Role_Id, Pant_Id) VALUES (:Role_Id, :Pant_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Pant_Id', $Pant_Id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception('Error al insertar la pantalla por rol: ' . $e->getMessage());
        }
    }
    
    

    public function eliminarPantallaPorRol($Role_Id) {
        try {
            $sql = 'CALL sp_PantallasPorRoles_eliminar(:Role_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn(); // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar pantalla por rol: ' . $e->getMessage());
        }
    }

    public function buscarPantallaPorRol($Paxr_Id) {
        try {
            $sql = 'CALL sp_PantallasPorRoles_buscar(:Paxr_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Paxr_Id', $Paxr_Id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error al buscar pantalla por rol: ' . $e->getMessage());
        }
    }

    public function actualizarPantallaPorRol($Paxr_Id, $Role_Id, $Pant_Id) {
        try {
            $sql = 'CALL sp_PantallasPorRoles_actualizar(:Paxr_Id, :Role_Id, :Pant_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Paxr_Id', $Paxr_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Role_Id', $Role_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Pant_Id', $Pant_Id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn(); // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar pantalla por rol: ' . $e->getMessage());
        }
    }

    public function listarPantallas() {
        try {
            $sql = 'CALL sp_Pantallas_listar()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (PDOException $e) {
            throw new Exception('Error al listar pantallas: ' . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new RolesController($pdo);

    switch ($_POST['action']) {
        case 'insertarRol':
            // Verificar si los parámetros existen en la solicitud POST
            $Role_Rol = isset($_POST['Role_Rol']) ? $_POST['Role_Rol'] : '';
            $Role_UsuarioCreacion = isset($_POST['Role_UsuarioCreacion']) ? $_POST['Role_UsuarioCreacion'] : '';
            $Role_FechaCreacion = isset($_POST['Role_FechaCreacion']) ? $_POST['Role_FechaCreacion'] : '';
            $Pantallas = isset($_POST['Pantallas']) ? $_POST['Pantallas'] : [];
            
            if (empty($Role_Rol) || empty($Role_UsuarioCreacion) || empty($Role_FechaCreacion)) {
                echo json_encode(['error' => 'Datos incompletos']);
                exit;
            }
            
            try {
                $nuevoId = $controller->insertarRol($Role_Rol, $Role_UsuarioCreacion, $Role_FechaCreacion);
            
                // Insertar las pantallas asociadas al rol
                foreach ($Pantallas as $Pant_Id) {
                    $controller->insertarPantallaPorRol($nuevoId, $Pant_Id);
                }
            
                echo json_encode(['nuevoRolId' => $nuevoId]);
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
            
        case 'actualizarRol':
            $Role_Id = $_POST['Role_Id'];
            $Role_Rol = $_POST['Role_Rol'];
            $Role_UsuarioModificacion = $_POST['Role_UsuarioModificacion'];
            $Role_FechaModificacion = $_POST['Role_FechaModificacion'];
            $resultado = $controller->actualizarRol($Role_Id, $Role_Rol, $Role_UsuarioModificacion, $Role_FechaModificacion);
            echo json_encode(['resultado' => $resultado]);
            break;
        case 'eliminarRol':
            $Role_Id = $_POST['Role_Id'];
            $resultado = $controller->eliminarRol($Role_Id);
            echo json_encode(['resultado' => $resultado]);
            break;
        case 'listarRoles':
            $controller->listarRoles();
            break;
        case 'listarPantallas':
            $controller->listarPantallas();
            break;
        case 'insertarPantallaPorRol':
            case 'insertarPantallaPorRol':
                $Role_Id = $_POST['data']['Role_Id']; // Acceder a Role_Id dentro de 'data'
                $Pant_Id = $_POST['data']['Pantallas']; // Acceder a Pantallas dentro de 'data'
                $resultado = $controller->insertarPantallaPorRol($Role_Id, $Pant_Id);
                echo json_encode(['resultado' => $resultado]);
                break;
            
        case 'eliminarPantallaPorRol':
            $Role_Id = $_POST['Role_Id'];
            $resultado = $controller->eliminarPantallaPorRol($Role_Id);
            echo json_encode(['resultado' => $resultado]);
            break;
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
}
