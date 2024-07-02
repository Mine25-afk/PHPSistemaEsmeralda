<?php
require_once __DIR__ . '/../config.php';
session_start();
class MarcaController {
   public function listarMarcas() {
    global $pdo;
    try {
        $sql = 'CALL SP_Marcas_Listar()';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $data = array();
        foreach ($result as $row) {
            $data[] = array(
                'Marc_Id' => $row['Marc_Id'],
                'Marc_Marca'=> $row['Marc_Marca']
            );
        }
        echo json_encode(array('data' => $data));
    } catch (Exception $e) {
        throw new Exception('Error al listar marcas: ' . $e->getMessage());
    }
}

    public function insertarMarca($Marc_Marca,$Marc_Id, $Marc_UsuarioCreacion, $Marc_FechaCreacion) {
        $Marc_Id = 0;
        global $pdo;
        try {
            $sql = 'CALL sp_Marcas_insertar(:Marc_Marca, :Marc_UsuarioCreacion, :Marc_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Marc_Marca', $Marc_Marca, PDO::PARAM_STR);
            $stmt->bindParam(':Marc_UsuarioCreacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Marc_FechaCreacion', $Marc_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }
    public function ActualizarMarca($Marc_Marca,$Marc_Id, $Marc_UsuarioCreacion, $Marc_FechaCreacion) {
        global $pdo;
        try {
            $sql = 'CALL SP_Marcas_actualizar(:Marc_Codigo, :Marc_Marca, :Marc_UsuarioModificacion, :Marc_FechaModificacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Marc_Codigo', $Marc_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Marc_Marca', $Marc_Marca, PDO::PARAM_STR);
            $stmt->bindParam(':Marc_UsuarioModificacion', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Marc_FechaModificacion', $Marc_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }

    public function EliminarMarca($Marc_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL SP_Marcas_Eliminar(:Marc_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Marc_Codigo', $Marc_Codigo, PDO::PARAM_INT);

            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }

    public function buscarMarcaPorCodigo($Marc_Id) {
        global $pdo;
        try {
            $sql = 'CALL SP_Marcas_buscar(:Marc_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Marc_Codigo', $Marc_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la marca: ' . $e->getMessage());
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new MarcaController();

    if ($_POST['action'] === 'listarMarcas') {
        $controller->listarMarcas();
    } elseif ($_POST['action'] === 'insertar') {
        $Marc_Marca = $_POST['Marc_Marca'];
        $Marc_Id = $_POST['Marc_Id'];
        $Marc_UsuarioCreacion = $_POST['Marc_UsuarioCreacion'];
        $Marc_FechaCreacion = $_POST['Marc_FechaCreacion'];
        
        $resultado = $controller->insertarMarca($Marc_Marca,$Marc_Id, $Marc_UsuarioCreacion, $Marc_FechaCreacion);
        echo $resultado;
    }elseif ($_POST['action'] === 'actualizar') {
        $Marc_Marca = $_POST['Marc_Marca'];
        $Marc_Id = $_POST['Marc_Id'];
        $Marc_UsuarioCreacion = $_POST['Marc_UsuarioCreacion'];
        $Marc_FechaCreacion = $_POST['Marc_FechaCreacion'];
        
        $resultado = $controller->ActualizarMarca($Marc_Marca,$Marc_Id, $Marc_UsuarioCreacion, $Marc_FechaCreacion);
        echo $resultado;
    }
    elseif ($_POST['action'] === 'eliminar') {
        $Marc_Codigo = $_POST['Marc_Codigo'];
        $resultado = $controller->EliminarMarca($Marc_Codigo);
        echo $resultado;
    }elseif ($_POST['action'] === 'buscar') {
        $Marc_Id = $_POST['Marc_Id'];
        $resultado = $controller->buscarMarcaPorCodigo($Marc_Id);
        echo $resultado;
    }
}

?>