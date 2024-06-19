<?php
require_once __DIR__ . '/../config.php';
session_start();
class FacturaController {
    public function listarFactura() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Factura_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $confirmar = $row['Fact_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-confirmar'><i class='fas fa-eraser'></i> Confirmar</button>" : "";
                $editar = $row['Fact_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</button>" : "";
                $detalles = $row['Fact_Finalizado'] == 0 ? "<button style='margin: 0 5px;' class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i>Detalles</button>" : "";
                $acciones = "<div class='text-center'>" . $detalles . $editar . $confirmar . "</div>";
                $data[] = array(
                    'Fact_Id' => $row['Fact_Id'],
                    'Clie_Nombre'=> $row['Clie_Nombre'],
                    'Empl_Nombre'=> $row['Empl_Nombre'],
                    'Mepa_Metodo'=> $row['Mepa_Metodo'],
                    'Fact_Finalizado'=> $row['Fact_Finalizado'],
                    'Acciones' => $acciones
                );
            }
            echo json_encode(array('data' => $data));

        } catch (Exception $e) {
            throw new Exception('Error al listar facturas: ' . $e->getMessage());
        }
    }

    public function listarClientes() {
        global $pdo;
        try {
            $sql = 'CALL `SP_Clientes_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
       
            $data = [];
            foreach ($result as $row) {
                $data[] = [
                    'label' => $row['Clie_DNI'] . ' - ' . $row['NombreCompleto'],
                    'value' => $row['Clie_DNI'],
                    'id' => $row['Clie_Id'],
                    'nombre' => $row['NombreCompleto'],
                    'mayorista' => $row['Clie_esMayorista']
                ];
            }
            
            echo json_encode(['data' => $data]);
        } catch (Exception $e) {
            error_log('Error al listar clientes: ' . $e->getMessage());
            echo json_encode(['error' => 'Error al listar clientes: ' . $e->getMessage()]);
        }
    }
    public function ListarProductos() {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_ObtenerProductosPorSucursales`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(); // Asegúrate de obtener los datos como un array asociativo
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Categoria' => $row['Categoria'],
                    'Stock'=> $row['Stock'],
                    'Codigo' => $row['Codigo'],
                    'Producto'=> $row['Producto'],
                    'PrecioVenta'=> $row['PrecioVenta'], 
                    'PrecioMayorista'=> $row['PrecioMayorista'] // Nota: Asegúrate de que el nombre del campo coincide con el devuelto por el procedimiento
                );
            }
            echo json_encode(array('data' => $data));

        } catch (Exception $e) {
            throw new Exception('Error al listar facturas: ' . $e->getMessage());
        }
    }

    public function ConfirmarFactura($Fact_Codigo, $Fact_FechaFinalizado,$Fact_Pago, $Fact_Cambio) {
        global $pdo;
        try {
            $sql = 'CALL sp_ConfirmarFactura(:Fact_Codigo,:Fact_FechaFinalizado,:Fact_Pago,:Fact_Cambio)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Fact_FechaFinalizado',$Fact_FechaFinalizado, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Pago', $Fact_Pago, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Cambio', $Fact_Cambio, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }


    public function FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL SP_Facturas_Insertar(:Clie_Id,:Empl_Id,:Mepa_Id,:Sucu_Id,:Fact_UsuarioCreacion,:Fact_FechaCreacion,:Fact_UsuarioModificacion,:Fact_FechaModificacion,:Fact_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Id', $Clie_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $_SESSION['Empl_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Mepa_Id', $Mepa_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Id', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Fact_UsuarioCreacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Fact_FechaCreacion', $Fact_FechaCreacion, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_UsuarioModificacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Fact_FechaModificacion', $Fact_FechaModificacion, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->execute();
            
            $facturaId = $stmt->fetchColumn();
            return $facturaId; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }

    public function buscarProductoPorCodigo($Codigo) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_ObtenerProductosPorSucursalesPorCodigo`(:Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Codigo', $Codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la marca: ' . $e->getMessage());
        }
    }

    public function listarTarjetas()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Tarjetas_Listar`()';
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute();
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'tarj_id' => $row['tarj_Id'],
                    'tarj_Descripcion'=> $row['tarj_Descripcion']
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar cargos: ' . $e->getMessage());
        }
    }
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new FacturaController();

    if ($_POST['action'] === 'listarFactura') {
        $controller->listarFactura();
    } elseif ($_POST['action'] === 'confirmar') {
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Fact_FechaFinalizado = $_POST['Fact_FechaFinalizado'];
        $Fact_Pago = $_POST['Fact_Pago'];
        $Fact_Cambio = $_POST['Fact_Cambio'];
        
        $resultado = $controller->ConfirmarFactura($Fact_Codigo,$Fact_FechaFinalizado, $Fact_Pago, $Fact_Cambio);
        echo $resultado;
    }elseif ($_POST['action'] === 'insertarprimero') {
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $Fact_FechaCreacion = $_POST['Fact_FechaCreacion'];
        $Fact_FechaModificacion = $_POST['Fact_FechaModificacion'];
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $resultado = $controller->FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo);
        echo $resultado;
    }elseif ($_POST['action'] === 'listarProductos') {
        $controller->ListarProductos();
    }elseif ($_POST['action'] === 'listarClientes') {
        $controller->listarClientes();
    }elseif ($_POST['action'] === 'buscarCodigo') {
        $Codigo = $_POST['Codigo'];
        $resultado = $controller->buscarProductoPorCodigo($Codigo);
        echo $resultado;
    }elseif ($_POST['action'] === 'listartarjetas') {
    $controller->listarTarjetas();
   
    }
}
?>