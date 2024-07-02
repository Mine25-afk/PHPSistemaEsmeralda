<?php
require_once __DIR__ . '/../config.php';
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log');
class FacturaApartadoServices {
    public function listarFacturaApartado() {
        global $pdo;
        try {
            $sql = 'CALL SP_FacturaApartado_Listar()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
            $data = array();
            foreach ($result as $row) {
                $confirmar = $row['FacP_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-confirmar'><i class='fas fa-eraser'></i> Confirmar</button>" : "";
                $editar = $row['FacP_Finalizado'] == 1 ? "<button style='margin: 0 5px;' class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-edit'></i>Editar</button>" : "";
                $detalles = $row['FacP_Finalizado'] == 0 ? "<button style='margin: 0 5px;' class='btn btn-secondary btn-sm abrir-detalles'><i class='fas fa-eye'></i>Detalles</button>" : "";
                $acciones = "<div class='text-center'>" . $detalles . $editar . $confirmar . "</div>";
                $data[] = array(
                    'FacP_Id' => $row['FacP_Id'],
                    'Clie_Nombre'=> $row['Clie_Nombre'],
                    'Empl_Nombre'=> $row['Empl_Nombre'],
                    'Mepa_Metodo'=> $row['Mepa_Metodo'],
                    'FacP_Finalizado'=> $row['FacP_Finalizado'],
                    'Acciones' => $acciones
                );
            }
            echo json_encode(array('data' => $data));

        } catch (Exception $e) {
            throw new Exception('Error al listar facturas: ' . $e->getMessage());
        }
    }

    public function buscarFacturaPorCodigo($FacPId) {
        global $pdo;
        try {
            $sql = 'CALL sp_FacturaApartado_buscar(:FacPId)';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacPId', $FacPId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la marca: ' . $e->getMessage());
        }
    }

    
    public function buscarProductoPorCodigo($Codigo) {
        global $pdo;
        try {
            $sql = 'CALL SP_ObtenerProductosPorSucursalesPorCodigoApartado(:Codigo)';

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Codigo', $Codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            throw new Exception('Error al buscar la marca: ' . $e->getMessage());
        }
    }

    public function ListarProductos() {
        global $pdo;
        try {
            $sql = 'CALL SP_ObtenerProductosPorSucursalesFacturaApartado(:Sucu_Codigo)';

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

    public function listarTarjetas()
    {
        global $pdo;
        try {
            $sql = 'CALL SP_Tarjetas_Listar()';
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


    public function FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$FacP_FechaCreacion,$FacP_FechaModificacion,$FacP_FechaExpiracion,$FacP_Codigo,$FacP_PagoInicial,$FaxP_Diferenciador,$Prod_Nombre,$FaxP_Cantidad) {
        global $pdo;
        try {
            $sql = 'CALL SP_FacturasApartado_Insertar(:Clie_Id,:Empl_Id,:Mepa_Id,:Sucu_Id,:FacP_UsuarioCreacion,:FacP_FechaCreacion,:Fact_UsuarioModificacion,:Fact_FechaModificacion,:FacP_FechaExpiracion,:Fact_Codigo,:FacP_PagoInicial)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Id', $Clie_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $_SESSION['Empl_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Mepa_Id', $Mepa_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Id', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_UsuarioCreacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_FechaCreacion', $FacP_FechaCreacion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_UsuarioModificacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_FechaModificacion', $FacP_FechaModificacion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_FechaExpiracion', $FacP_FechaExpiracion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':FacP_PagoInicial', $FacP_PagoInicial, PDO::PARAM_STR);
            $stmt->execute();
            $facturaId = $stmt->fetchColumn();
            $stmt->closeCursor();
            $pdo->exec('SET SQL_SAFE_UPDATES = 0;');
            $sql = 'CALL SP_FacturaDetallesApartado_Insertar(:FaxP_Diferenciador,:Prod_Nombre,:FaxP_Cantidad,:FacP_Codigo,:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FaxP_Diferenciador', $FaxP_Diferenciador, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':FaxP_Cantidad', $FaxP_Cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':FacP_Codigo',  $facturaId, PDO::PARAM_INT);
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

    public function EliminarFacturaDetalle($FacP_Codigo, $Sucu_Codigo,$Prod_Nombre_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL sp_FacturaDetallesApartado_eliminar(:FacP_Codigo,:Sucu_Codigo,:Prod_Nombre_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre_Codigo', $Prod_Nombre_Codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }

    public function DevolucionFacturaDetalle($FacP_Codigo, $Sucu_Codigo) {
        global $pdo;
        try {
            $sql = 'CALL sp_FacturaDetallesApartado_Devolucion(:FacP_Codigo,:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchColumn();
            return $result; 
        } catch (PDOException $e) {
            return 0; 
        }
    }
    public function FacturaInsertarDespues($Clie_Id,$Mepa_Id,$FacP_FechaCreacion,$FacP_FechaModificacion,$FacP_FechaExpiracion,$FacP_Codigo,$FacP_PagoInicial,$FaxP_Diferenciador,$Prod_Nombre,$FaxP_Cantidad) {
        global $pdo;
        try {
            $sql = 'CALL SP_FacturasApartado_Insertar(:Clie_Id,:Empl_Id,:Mepa_Id,:Sucu_Id,:FacP_UsuarioCreacion,:FacP_FechaCreacion,:Fact_UsuarioModificacion,:Fact_FechaModificacion,:FacP_FechaExpiracion,:Fact_Codigo,:FacP_PagoInicial)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Clie_Id', $Clie_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Empl_Id', $_SESSION['Empl_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Mepa_Id', $Mepa_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Id', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_UsuarioCreacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_FechaCreacion', $FacP_FechaCreacion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_UsuarioModificacion',  $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':FacP_FechaModificacion', $FacP_FechaModificacion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_FechaExpiracion', $FacP_FechaExpiracion, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':FacP_PagoInicial', $FacP_PagoInicial, PDO::PARAM_STR);
            $stmt->execute();
            $facturaId = $stmt->fetchColumn();
            $stmt->closeCursor();
            $sql = 'CALL sp_FacturaDetallesApartado_eliminar(:FacP_Codigo,:Sucu_Codigo,:Prod_Nombre_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':Sucu_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre_Codigo', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();
            $pdo->exec('SET SQL_SAFE_UPDATES = 0;');
            $sql = 'CALL SP_FacturaDetallesApartado_Insertar(:FaxP_Diferenciador,:Prod_Nombre,:FaxP_Cantidad,:FacP_Codigo,:Sucu_Codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FaxP_Diferenciador', $FaxP_Diferenciador, PDO::PARAM_INT);
            $stmt->bindParam(':Prod_Nombre', $Prod_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':FaxP_Cantidad', $FaxP_Cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':FacP_Codigo',  $facturaId, PDO::PARAM_INT);
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

    public function ConfirmarFactura($FacP_Codigo, $FacP_FechaFinalizado,$FacP_PagoFinal, $FacP_Cambio,$Tarj_Id,$Tarj_Codigo,$FacP_Total) {
        global $pdo;
        try {
            $sql = 'CALL sp_ConfirmarFacturaApartado(:FacP_Codigo,:FacP_FechaFinalizado,:FacP_PagoFinal,:FacP_Cambio,:Tarj_Id,:Tarj_Codigo,:FacP_Total)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacP_Codigo', $FacP_Codigo, PDO::PARAM_INT);
            $stmt->bindParam(':FacP_FechaFinalizado',$FacP_FechaFinalizado, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_PagoFinal', $FacP_PagoFinal, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_Cambio', $FacP_Cambio, PDO::PARAM_STR);
            $stmt->bindParam(':Tarj_Id', $Tarj_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Tarj_Codigo', $Tarj_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':FacP_Total', $FacP_Total, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }

    public function TablaProductoFactura($FacPId, $Mayorista) {
        global $pdo;
        try {
            $sql = 'CALL `SP_FacturaDetallesApartado_ProductosVentas`(:FacPId, :Mayorista)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':FacPId', $FacPId, PDO::PARAM_INT);
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

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $controller = new FacturaApartadoServices();

    switch ($_POST['action']) {
        case 'listarFacturaApartado':
        $controller->listarFacturaApartado();
        break;
        case 'BuscarFacturaApartado':
        $FacPId = $_POST['FacPId'];
        $resultado = $controller->buscarFacturaPorCodigo($FactId);
        echo $resultado;
        break;
        case 'ObtenerProductosPorCodigo':
        $Codigo = $_POST['Codigo'];
        $resultado = $controller->buscarProductoPorCodigo($Codigo);
        echo $resultado;
        break;
        case 'ObtenerProductos':
        $controller->ListarProductos();
        break;
        case 'ListarClientes':
        $controller->listarClientes();
        break;
        case 'ListarTarjetas':
        echo $controller->listarTarjetas();
        break;
        case 'InsertarPrimero':
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $FacP_FechaCreacion = $_POST['FacP_FechaCreacion'];
        $FacP_FechaModificacion = $_POST['FacP_FechaModificacion'];
        $FacP_FechaExpiracion = $_POST['FacP_FechaExpiracion'];
        $FacP_Codigo = $_POST['FacP_Codigo'];
        $FacP_PagoInicial = $_POST['FacP_PagoInicial'];
        $FaxP_Diferenciador = $_POST['FaxP_Diferenciador'];
        $Prod_Nombre = $_POST['Prod_Nombre'];
        $FaxP_Cantidad = $_POST['FaxP_Cantidad'];
        $resultado = $controller->FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$FacP_FechaCreacion,$FacP_FechaModificacion,$FacP_FechaExpiracion,$FacP_Codigo,$FacP_PagoInicial,$FaxP_Diferenciador,$Prod_Nombre,$FaxP_Cantidad);
        echo $resultado;
        break;
        case 'InsertarDespues':
        $Clie_Id = $_POST['Clie_Id'];
        $Mepa_Id = $_POST['Mepa_Id'];
        $FacP_FechaCreacion = $_POST['FacP_FechaCreacion'];
        $FacP_FechaModificacion = $_POST['FacP_FechaModificacion'];
        $FacP_FechaExpiracion = $_POST['FacP_FechaExpiracion'];
        $FacP_Codigo = $_POST['FacP_Codigo'];
        $FacP_PagoInicial = $_POST['FacP_PagoInicial'];
        $FaxP_Diferenciador = $_POST['FaxP_Diferenciador'];
        $Prod_Nombre = $_POST['Prod_Nombre'];
        $FaxP_Cantidad = $_POST['FaxP_Cantidad'];
        $resultado = $controller->FacturaInsertarPrimero($Clie_Id,$Mepa_Id,$FacP_FechaCreacion,$FacP_FechaModificacion,$FacP_FechaExpiracion,$FacP_Codigo,$FacP_PagoInicial,$FaxP_Diferenciador,$Prod_Nombre,$FaxP_Cantidad);
        echo $resultado;
        break;
        case 'EliminarFacturaDetalles':
        $FacP_Codigo = $_POST['FacP_Codigo'];
        $Sucu_Codigo = $_POST['Sucu_Codigo'];
        $Prod_Nombre_Codigo = $_POST['Prod_Nombre_Codigo'];
        $resultado = $controller->EliminarFacturaDetalle($FacP_Codigo,$Sucu_Codigo, $Prod_Nombre_Codigo);
        echo $resultado;
        break;
        case 'Devolucion':
        $FacP_Codigo = $_POST['FacP_Codigo'];
        $Sucu_Codigo = $_POST['Sucu_Codigo'];
        $resultado = $controller->DevolucionFacturaDetalle($FacP_Codigo,$Sucu_Codigo, $Prod_Nombre_Codigo);
        echo $resultado;
        break;
        case 'Confirmar':
        $FacP_Codigo = $_POST['FacP_Codigo'];
        $FacP_FechaFinalizado = $_POST['FacP_FechaFinalizado'];
        $FacP_PagoFinal = $_POST['FacP_PagoFinal'];
        $FacP_Cambio = $_POST['FacP_Cambio'];
        $Tarj_Id= $_POST['Tarj_Id'];
        $Tarj_Codigo= $_POST['Tarj_Codigo'];
        $FacP_Total= $_POST['FacP_Total'];
        $resultado = $controller->ConfirmarFactura($FacP_Codigo,$FacP_FechaFinalizado, $FacP_PagoFinal, $FacP_Cambio,$Tarj_Id,$Tarj_Codigo,$FacP_Total);
        echo $resultado;
        break;
        case 'ListaProductos':
        $FacPId = $_POST['FacPId'];
        $Mayorista = $_POST['mayorista'];
        echo $controller->TablaProductoFactura($FacPId,$Mayorista);
        break;
       
    }
}
?>
