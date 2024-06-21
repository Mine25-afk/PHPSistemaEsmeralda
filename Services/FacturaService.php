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
                $confirmar = $row['Fact_Finalizado'] == 1 ? " <a class='dropdown-item abrir-confirmar'><i class='fas fa-trash-alt'></i> Confirmar</a>" : "";
                $editar = $row['Fact_Finalizado'] == 1 ? "<a class='dropdown-item abrir-editar'><i class='fas fa-edit'></i> Editar</a>" : "";
                $detalles = $row['Fact_Finalizado'] == 0 ? "<a class='dropdown-item abrir-detalles'><i class='fas fa-info-circle'></i> Detalles</a>" : "";
                $acciones = "<div class='text-center'> <div class='btn-group'> <button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'><i class='fas fa-cogs'></i> Acciones</button><div class='dropdown-menu'>" . $detalles . $editar . $confirmar . "</div> </div></div>";
                $data[] = array(
                    'Fact_Id' => $row['Fact_Id'],
                    'Clie_Nombre'=> $row['Clie_Nombre'],
                    'Empl_Nombre'=> $row['Empl_Nombre'],
                    'Mepa_Metodo'=> $row['Mepa_Metodo'],
                    'Fact_Finalizado'=> $row['Fact_Finalizado'],
                    'Clie_EsMayorista'=> $row['Clie_EsMayorista'],
                    'Fact_Impuesto'=> $row['Fact_Impuesto'],
                    'Clie_DNI'=> $row['Clie_DNI'],

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
            $sql = 'CALL `dbsistemaesmeralda`.`SP_ObtenerProductosPorSucursalesFiltrado`(:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
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

    public function ConfirmarFactura($Fact_Codigo, $Fact_FechaFinalizado,$Fact_Pago, $Fact_Cambio,$Tarj_Id,$Tarj_Codigo,$Fact_Total) {
        global $pdo;
        try {
            $sql = 'CALL sp_ConfirmarFactura(:Fact_Codigo,:Fact_FechaFinalizado,:Fact_Pago,:Fact_Cambio,:Tarj_Id,:Tarj_Codigo,:Fact_Total)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Fact_FechaFinalizado',$Fact_FechaFinalizado, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Pago', $Fact_Pago, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Cambio', $Fact_Cambio, PDO::PARAM_STR);
            $stmt->bindParam(':Tarj_Id', $Tarj_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Tarj_Codigo', $Tarj_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Total', $Fact_Total, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }

    public function EliminarFacturaDetalle($Fact_Codigo, $Sucu_Codigo,$Prod_Nombre_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL sp_FacturaDetalles_eliminar(:Fact_Codigo,:Sucu_Codigo,:Prod_Nombre_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre_Codigo', $Prod_Nombre_Codigo, PDO::PARAM_STR);

            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }

    public function EliminarFacturaDetalleReparaciones($FaxD_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL sp_FacturaDetalles_eliminarReparaciones(:FaxD_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FaxD_Codigo', $FaxD_Codigo, PDO::PARAM_INT);

            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }

    
    public function FacturaInsertarDespues($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Nombre,$Faxd_Cantidad) {
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
            $stmt->closeCursor();
            $sql = 'CALL sp_FacturaDetalles_eliminar(:Fact_Codigo,:Sucu_Codigo,:Prod_Nombre_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Fact_Codigo', $Fact_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre_Codigo', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $pdo->exec('SET SQL_SAFE_UPDATES = 0;');
            $sql = 'CALL SP_FacturaDetalles_Insertar(:Faxd_Diferenciador,:Prod_Nombre,:Faxd_Cantidad,:Fact_Codigo,:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Faxd_Diferenciador', $Faxd_Diferenciador, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Faxd_Cantidad', $Faxd_Cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':Fact_Codigo',  $facturaId, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->execute();
            
            $resulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($resulta as $row) {
                $data[] = array(
                    'TotalStock' => $row['TotalStock'],
                    'Resultado' => $row['Resultado']
                );
            }
            return json_encode(array('data' => $data));
        } catch (PDOException $e) {
            return $e; 
        }
    }

    public function FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Nombre,$Faxd_Cantidad) {
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
            $stmt->closeCursor();
            $pdo->exec('SET SQL_SAFE_UPDATES = 0;');
            $sql = 'CALL SP_FacturaDetalles_Insertar(:Faxd_Diferenciador,:Prod_Nombre,:Faxd_Cantidad,:Fact_Codigo,:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Faxd_Diferenciador', $Faxd_Diferenciador, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Faxd_Cantidad', $Faxd_Cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':Fact_Codigo',  $facturaId, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->execute();
            
            $resulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($resulta as $row) {
                $data[] = array(
                    'TotalStock' => $row['TotalStock'],
                    'Resultado' => $row['Resultado']
                );
            }
            return json_encode(array('data' => $data));
        } catch (PDOException $e) {
            return $e; 
        }
    }

    public function FacturaInsertarReparacion($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Codigo,$FaxD_Producto,$FaxD_Precio) {
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
            $stmt->closeCursor();
            $pdo->exec('SET SQL_SAFE_UPDATES = 0;');
            $sql = 'CALL SP_FacturaDetallesReparaciones_Insertar(:Faxd_Diferenciador,:Prod_Codigo,:Fact_Codigo,:FaxD_Producto,:FaxD_Precio)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Faxd_Diferenciador', $Faxd_Diferenciador, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Codigo', $Prod_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Fact_Codigo', $facturaId, PDO::PARAM_INT);
            $stmt->bindParam(':FaxD_Producto', $FaxD_Producto , PDO::PARAM_STR);
            $stmt->bindParam(':FaxD_Precio', $FaxD_Precio, PDO::PARAM_STR);
            $stmt->execute();
            
            $resulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($resulta as $row) {
                $data[] = array(
                    'TotalStock' => $row['TotalStock'],
                    'Resultado' => $row['Resultado']
                );
            }
            return json_encode(array('data' => $data));
        } catch (PDOException $e) {
            return $e; 
        }
    }

    public function TablaProductoFactura($FactId, $Mayorista) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaDetalles_ProductosVentas`(:FactId, :Mayorista)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FactId', $FactId, PDO::PARAM_INT);
            $stmt->bindParam(':Mayorista', $Mayorista, PDO::PARAM_BOOL);
            $stmt->execute();
            
            // Verifica si la consulta devolvió resultados
            $result = $stmt->fetchAll();
            if ($result === false) {
                // Obtén información del error
                $errorInfo = $stmt->errorInfo();
                throw new Exception('Error en la consulta SQL: ' . $errorInfo[2]);
            }
            
            $data = array();
            foreach ($result as $row) {
                $data[] = array(
                    'Row' => $row['CodigoRow'],
                    'FaxD_Id' => $row['FaxD_Id'],
                    'Prod_Codigo' => $row['Prod_Codigo'],
                    'Producto' => $row['Producto'],
                    'Cantidad' => $row['Cantidad'],
                    'Precio_Unitario' => $row['Precio_Unitario'],
                    'Total' => $row['Total'],
                    'Categoria' => $row['Categoria']
                );
            }
            return json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la marca: ' . $e->getMessage());
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

    public function buscarFacturaPorCodigo($FactId) {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`sp_Factura_buscar`(:FactId)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FactId', $FactId, PDO::PARAM_INT);
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
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($result as $row) {
                // Excluir el ID 3 si no lo has hecho en el SP
                if ($row['tarj_Id'] != 3) {
                    $data[] = array(
                        'tarj_id' => $row['tarj_Id'],
                        'tarj_Descripcion'=> $row['tarj_Descripcion']
                    );
                }
            }
            return json_encode(array('data' => $data));
        } catch (Exception $e) {
            throw new Exception('Error al listar tarjetas: ' . $e->getMessage());
        }
    }
}

// Main logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    $controller = new FacturaController();

    if ($_POST['action'] == 'listarFactura') {
        $controller->listarFactura();
    }elseif ($_POST['action'] == 'listarproductos_Factura') {
        $Fact_Id = $_POST['fact_Id'];
        $Mayorista = $_POST['mayorista'];
        echo $controller->TablaProductoFactura($Fact_Id,$Mayorista);
       
        } elseif ($_POST['action'] === 'eliminarDetalle') {
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Sucu_Codigo = $_POST['Sucu_Codigo'];
        $Prod_Nombre_Codigo = $_POST['Prod_Nombre_Codigo'];

        
        $resultado = $controller->EliminarFacturaDetalle($Fact_Codigo,$Sucu_Codigo, $Prod_Nombre_Codigo);
        echo $resultado;
    } elseif ($_POST['action'] === 'eliminarDetalleReparaciones') {
        $FaxD_Codigo = $_POST['FaxD_Codigo'];


        
        $resultado = $controller->EliminarFacturaDetalleReparaciones($FaxD_Codigo);
        echo $resultado;
    }elseif ($_POST['action'] === 'listarFacturaId') {
        $FactId = $_POST['FactId'];


        
        $resultado = $controller->buscarFacturaPorCodigo($FactId);
        echo $resultado;
    }elseif ($_POST['action'] === 'confirmar') {
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Fact_FechaFinalizado = $_POST['Fact_FechaFinalizado'];
        $Fact_Pago = $_POST['Fact_Pago'];
        $Fact_Cambio = $_POST['Fact_Cambio'];
        $Tarj_Id= $_POST['Tarj_Id'];
        $Tarj_Codigo= $_POST['Tarj_Codigo'];
        $Fact_Total= $_POST['Fact_Total'];
        $resultado = $controller->ConfirmarFactura($Fact_Codigo,$Fact_FechaFinalizado, $Fact_Pago, $Fact_Cambio,$Tarj_Id,$Tarj_Codigo,$Fact_Total);
        echo $resultado;
    }elseif ($_POST['action'] === 'insertarprimero') {
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $Fact_FechaCreacion = $_POST['Fact_FechaCreacion'];
        $Fact_FechaModificacion = $_POST['Fact_FechaModificacion'];
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Faxd_Diferenciador = $_POST['Faxd_Diferenciador'];
        $Prod_Nombre = $_POST['Prod_Nombre'];
        $Faxd_Cantidad = $_POST['Faxd_Cantidad'];

        $resultado = $controller->FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Nombre,$Faxd_Cantidad);
        echo $resultado;
    }elseif ($_POST['action'] === 'insertardespues') {
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $Fact_FechaCreacion = $_POST['Fact_FechaCreacion'];
        $Fact_FechaModificacion = $_POST['Fact_FechaModificacion'];
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Faxd_Diferenciador = $_POST['Faxd_Diferenciador'];
        $Prod_Nombre = $_POST['Prod_Nombre'];
        $Faxd_Cantidad = $_POST['Faxd_Cantidad'];

        $resultado = $controller->FacturaInsertarDespues($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Nombre,$Faxd_Cantidad);
        echo $resultado;
    }elseif ($_POST['action'] === 'insertarreparacion') {
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $Fact_FechaCreacion = $_POST['Fact_FechaCreacion'];
        $Fact_FechaModificacion = $_POST['Fact_FechaModificacion'];
        $Fact_Codigo = $_POST['Fact_Codigo'];
        $Faxd_Diferenciador = $_POST['Faxd_Diferenciador'];
        $Prod_Codigo = $_POST['Prod_Codigo'];
        $FaxD_Producto = $_POST['FaxD_Producto'];
        $FaxD_Precio = $_POST['FaxD_Precio'];

        $resultado = $controller->FacturaInsertarReparacion($Clie_Id,$Mepa_Id,$Fact_FechaCreacion,$Fact_FechaModificacion,$Fact_Codigo,$Faxd_Diferenciador,$Prod_Codigo,$FaxD_Producto,$FaxD_Precio);
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
    echo $controller->listarTarjetas();
   
    }
}
?>