<?php
require_once __DIR__ . '/../config.php';

class JoyasController {
   public function listarJoyas() {
    global $pdo;
    try {
        $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listar`()';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $data = array();
        foreach ($result as $row) {
            $data[] = array(
                'Joya_Id' => $row['Joya_Id'],
                'Joya_Nombre' => $row['Joya_Nombre']
                'Joya_PrecioCompra' => $row['Joya_PrecioCompra']
                'Joya_PrecioVenta' => $row['Joya_PrecioVenta']
                'Joya_Stock' => $row['Joya_Stock']
                'Joya_PrecioMayor' => $row['Joya_PrecioMayor']
                'Joya_Imagen' => $row['Joya_Imagen']
                'Mate_Material' => $row['Mate_Material']
                'Prov_Proveedor' => $row['Prov_Proveedor']
                'Cate_Categoria' => $row['Cate_Categoria']
            );
        }

        echo json_encode(array('data' => $data));
    } catch (Exception $e) {
        throw new Exception('Error al listar joyas: ' . $e->getMessage());
    }
}

    public function insertarJoyas($Joya_Nombre,$Joya_PrecioCompra,$Joya_PrecioVenta,$Joya_PrecioMayor,$Joya_Imagen,$Joya_Stock,$Prov_Id,$Mate_Id,$Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion) {
        global $pdo;
        try {
            $sql = 'CALL SP_Joyas_insertar(:Joya_Nombre,:Joya_PrecioCompra,:Joya_PrecioVenta,:Joya_PrecioMayor,:Joya_Imagen,:Joya_Stock,:Prov_Id,:Mate_Id,:Cate_Id, :Joya_UsuarioCreacion, :Joya_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Nombre', $Joya_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioCompra', $Joya_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioVenta', $Joya_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioMayor', $Joya_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Imagen', $Joya_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Stock', $Joya_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Mate_Id', $Mate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Cate_Id', $Cate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_UsuarioCreacion', $Joya_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_FechaCreacion', $Joya_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new JoyasController();

    if ($_POST['action'] === 'listarJoyas') {
        $controller->listarJoyas();
    } elseif ($_POST['action'] === 'insertar') {
        $Joya_Nombre = $_POST['Joya_Nombre'];
        $Joya_UsuarioCreacion = $_POST['Joya_UsuarioCreacion'];
        $Joya_FechaCreacion = $_POST['Joya_FechaCreacion'];
        
        $resultado = $controller->insertarJoyas($Joya_Nombre,$Joya_PrecioCompra,$Joya_PrecioVenta,$Joya_PrecioMayor,$Joya_Imagen,$Joya_Stock,$Prov_Id,$Mate_Id,$Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion);
        echo $resultado;
    }
}

?>