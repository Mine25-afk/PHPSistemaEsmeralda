<?php
require_once __DIR__ . '/../config.php';

class ReparacionesController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function listarReparaciones() {
        try {
            $sql = 'CALL SP_Reparaciones_listar()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Repa_Id' => $row['Repa_Id'],
                    'Repa_Codigo' => $row['Repa_Codigo'],
                    'Repa_Tipo_Reparacion' => $row['Repa_Tipo_Reparacion']
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar reparaciones: ' . $e->getMessage());
        }
    }

    public function insertarReparacion($Repa_Tipo_Reparacion, $Repa_UsuarioCreacion, $Repa_FechaCreacion) {
        try {
            $sql = 'CALL sp_Reparaciones_insertar(:Repa_Tipo_Reparacion, :Repa_UsuarioCreacion, :Repa_FechaCreacion)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Repa_Tipo_Reparacion', $Repa_Tipo_Reparacion, PDO::PARAM_STR);
            $stmt->bindParam(':Repa_UsuarioCreacion', $Repa_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Repa_FechaCreacion', $Repa_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al insertar la Reparación: ' . $e->getMessage());
        }
    }

    public function actualizarReparacion($Repa_Id, $Repa_Tipo_Reparacion, $Repa_UsuarioModifica, $Repa_FechaModifica) {
        try {
            $sql = 'CALL SP_reparaciones_actualizar(:Repa_Id, :Repa_Tipo_Reparacion, :Repa_UsuarioModifica, :Repa_FechaModifica)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':Repa_Id', $Repa_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Repa_Tipo_Reparacion', $Repa_Tipo_Reparacion, PDO::PARAM_STR);
            $stmt->bindParam(':Repa_UsuarioModifica', $Repa_UsuarioModifica, PDO::PARAM_INT);
            $stmt->bindParam(':Repa_FechaModifica', $Repa_FechaModifica, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al actualizar la Reparación: ' . $e->getMessage());
        }
    }

    public function buscarReparacion($Repa_Id) {
        try {
            $sql = 'CALL SP_Reparaciones_buscar(:RepaId_buscar)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':RepaId_buscar', $Repa_Id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            throw new Exception('Error al buscar la Reparación: ' . $e->getMessage());
        }
    }

    public function eliminarReparacion($Repa_Id) {
        try {
            $sql = 'CALL SP_reparaciones_eliminar(:r_Repa_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':r_Repa_Id', $Repa_Id, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            throw new Exception('Error al eliminar la Reparación: ' . $e->getMessage());
        }
    }
}


// Aquí comienza tu código existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new ReparacionesController($pdo);

    if ($_POST['action'] === 'insertar') {
  
        $Repa_Tipo_Reparacion = $_POST['Repa_Tipo_Reparacion'];
        $Repa_UsuarioCreacion = $_POST['Repa_UsuarioCreacion'];
        $Repa_FechaCreacion = $_POST['Repa_FechaCreacion'];
        
        $resultado = $controller->insertarReparacion($Repa_Tipo_Reparacion, $Repa_UsuarioCreacion, $Repa_FechaCreacion);
        echo $resultado;
    } elseif ($_POST['action'] === 'actualizar') {
        $Repa_Id = $_POST['Repa_Id'];

        $Repa_Tipo_Reparacion = $_POST['Repa_Tipo_Reparacion'];
        $Repa_UsuarioModifica = $_POST['Repa_UsuarioModifica'];
        $Repa_FechaModifica = $_POST['Repa_FechaModifica'];

        $resultado = $controller->actualizarReparacion($Repa_Id, $Repa_Tipo_Reparacion, $Repa_UsuarioModifica, $Repa_FechaModifica);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarReparaciones') {
        $controller->listarReparaciones();
    } elseif ($_POST['action'] === 'eliminar') {
        $Repa_Id = $_POST['Repa_Id'];
        $resultado = $controller->eliminarReparacion($Repa_Id);
        
        // Manejar el resultado de la ejecución del procedimiento almacenado
        if ($resultado === '0') {
            throw new Exception('El procedimiento almacenado no tuvo efecto.');
        } else {
            echo $resultado; // Esto puede ser útil para depurar, pero considera cómo quieres mostrar la respuesta al usuario
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'buscar') {
    $controller = new ReparacionesController($pdo);

    $Repa_Id = $_GET['Repa_Id'];
    $resultado = $controller->buscarReparacion($Repa_Id);
    echo json_encode($resultado);
}
?>

