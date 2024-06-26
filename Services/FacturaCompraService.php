<?php
require_once __DIR__ . '/../config.php';
session_start();

class FacturaCompraService
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listarFacturaCompras()
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Listar`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($result as $row) {
                $editar = $row['faCE_Finalizada'] == 'Si' ? "<button style='margin: 0 5px;' class='btn btn-primary btn-sm abrir-editar'><i class='fas fa-pencil-alt'></i> Editar</button>" : "";
                $imprimir = $row['faCE_Finalizada'] == 'No' ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-imprimir' ><i class='fas fa-print'></i> Imprimir</button>" : "";
                $finalizar = $row['faCE_Finalizada'] == 'Si' ? "<button style='margin: 0 5px;' class='btn btn-danger btn-sm abrir-finalizar'><i class='fas fa-check-circle'></i> Finalizar</button>" : "";
                $acciones = "<div class='text-center'>" . $editar . $imprimir . $finalizar . "</div>";
                $data[] = array(
                    'FaCE_Id' => $row['FaCE_Id'],
                    'nombreProveedor' => $row['nombreProveedor'],
                    'mepa_Metodo' => $row['mepa_Metodo'],
                    'faCE_Finalizada' => $row['faCE_Finalizada'],
                    'Acciones' => $acciones
                );
            }
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            error_log('Error al listar la factura de compra: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar la factura de compra.'));
        }
    }

    public function listarSucursales()
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Sucursales_Listar`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            error_log('Error al listar sucursales: ' . $e->getMessage());
            throw new Exception('Error al listar sucursales.');
        }
    }

    public function listarProveedores()
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Proveedor_listar`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            error_log('Error al listar proveedores: ' . $e->getMessage());
            throw new Exception('Error al listar proveedores.');
        }
    }

    public function buscarFacturaCompraPorCodigo($FaCE_Id)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Buscar`(:FaCE_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al buscar la factura compra: ' . $e->getMessage());
            throw new Exception('Error al buscar la factura compra.');
        }
    }

    public function listarJoyasAutoCompletado($term)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_listarAutoCompletado1`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al listar joyas para autocompletado: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar joyas para autocompletado.'));
        }
    }

    public function listarMaquillajesAutoCompletado($term)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Maquillajes_listarAutoCompletado1`()';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al listar maquillajes para autocompletado: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar maquillajes para autocompletado.'));
        }
    }

    public function buscarMaquillajePorCodigo($codigo)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Maquillajes_Buscarr`(:codigo)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al buscar maquillaje por código: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al buscar maquillaje por código.'));
        }
    }

    public function buscarJoyaPorCodigo($codigo)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Joyas_Buscarr`(:codigo)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al buscar joya por código: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al buscar joya por código.'));
        }
    }

    public function insertarFacturaEncabezado($proveedor, $sucursal, $metodoPago, $usuarioCreacion, $fechaCreacion)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Insertar`(:proveedor, :metodoPago, :sucursal, :usuarioCreacion, :fechaCreacion, null, null, 0, @p_ID)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':proveedor', $proveedor, PDO::PARAM_INT);
            $stmt->bindParam(':metodoPago', $metodoPago, PDO::PARAM_INT);
            $stmt->bindParam(':sucursal', $sucursal, PDO::PARAM_INT);
            $stmt->bindParam(':usuarioCreacion', $usuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':fechaCreacion', $fechaCreacion, PDO::PARAM_STR);
            $stmt->execute();
            $stmt->closeCursor();

            $result = $this->pdo->query("SELECT @p_ID as FaCE_Id")->fetch(PDO::FETCH_ASSOC);
            if ($result && isset($result['FaCE_Id'])) {
                return array('success' => true, 'FaCE_Id' => $result['FaCE_Id']);
            } else {
                throw new Exception('No se pudo obtener el ID del encabezado de factura.');
            }
        } catch (Exception $e) {
            error_log('Error al insertar la factura: ' . $e->getMessage());
            return array('error' => 'Error al insertar la factura: ' . $e->getMessage());
        }
    }


    public function insertarDetalleFactura($FaCE_Id, $producto, $cantidad, $precioCompra, $precioVenta, $precioMayorista, $categoria)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompraDetalle_Insertar`(:FaCE_Id, :categoria, :producto, :cantidad, :precioCompra, :precioVenta, :precioMayorista)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_INT);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_INT);
            $stmt->bindParam(':producto', $producto, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precioCompra', $precioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':precioVenta', $precioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':precioMayorista', $precioMayorista, PDO::PARAM_STR);
            $stmt->execute();
            return array('success' => true);
        } catch (Exception $e) {
            error_log('Error al insertar el detalle de la factura: ' . $e->getMessage());
            return array('error' => 'Error al insertar el detalle de la factura: ' . $e->getMessage());
        }
    }

    public function obtenerFacturaCompraDetalleId($FaCE_Id, $producto, $FaCD_Dif)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_ObtenerFacturaCompraDetalleId`(:FaCE_Id, :producto, :FaCD_Dif)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_INT);
            $stmt->bindParam(':producto', $producto, PDO::PARAM_STR);
            $stmt->bindParam(':FaCD_Dif', $FaCD_Dif, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['FaCD_Id'] : null;
        } catch (Exception $e) {
            error_log('Error al obtener el ID del detalle de la factura: ' . $e->getMessage());
            return null;
        }
    }


    public function eliminarDetalleFactura($FaCD_Id)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompraDetalle_Eliminar`(:FaCD_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCD_Id', $FaCD_Id, PDO::PARAM_INT);
            $stmt->execute();
            return array('success' => true);
        } catch (Exception $e) {
            error_log('Error al eliminar el detalle de la factura: ' . $e->getMessage());
            return array('error' => 'Error al eliminar el detalle de la factura: ' . $e->getMessage());
        }
    }

    public function buscarFacturaDetalle($FaCE_Id)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompraDetalle_Listar`(:FaCE_Id)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($result);
        } catch (Exception $e) {
            error_log('Error al buscar joya por código: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al buscar detalle.'));
        }
    }

    public function finalizarFacturaCompra($FaCE_Id, $fechaFinal)
    {
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_FacturaCompra_Finalizar`(:FaCE_Id, :fechaFinal)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':FaCE_Id', $FaCE_Id, PDO::PARAM_INT);
            $stmt->bindParam(':fechaFinal', $fechaFinal, PDO::PARAM_STR);
            $stmt->execute();
            return array('success' => true);
        } catch (Exception $e) {
            error_log('Error al finalizar la factura: ' . $e->getMessage());
            return array('error' => 'Error al finalizar la factura: ' . $e->getMessage());
        }
    }

    public function listarMateriales()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Materiales_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar materiales: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar materiales: ' . $e->getMessage()));
        }
    }

    public function listarCategorias()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Categorias_listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar categorías: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar categorías: ' . $e->getMessage()));
        }
    }
    public function listarMarcas()
    {
        global $pdo;
        try {
            $sql = 'CALL `dbsistemaesmeralda`.`SP_Marcas_Listar`()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } catch (Exception $e) {
            error_log('Error al listar marcas: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al listar marcas: ' . $e->getMessage()));
        }
    }
    public function insertarProducto($tipo, $datos)
    {
        error_log('insertarProducto: Tipo de producto: ' . $tipo);
        error_log('insertarProducto: Datos: ' . json_encode($datos));

        if ($tipo === 'joya') {
            return $this->insertarJoyas(
                $datos['productoCodigo'],
                $datos['nombre'],
                $datos['precio_compra'],
                $datos['precio_venta'],
                $datos['precio_mayorista'],
                $datos['imagen'],
                $datos['stock'],
                $datos['proveedor'],
                $datos['material'],
                $datos['categoria'],
                $datos['usuario_creacion'],
                $datos['fecha_creacion']
            );
        } elseif ($tipo === 'maquillaje') {
            return $this->insertarMaquillaje(
                $datos['productoCodigo'],
                $datos['nombre'],
                $datos['precio_compra'],
                $datos['precio_venta'],
                $datos['precio_mayorista'],
                $datos['imagen'],
                $datos['stock'],
                $datos['proveedor'],
                $datos['marca'],
                $datos['usuario_creacion'],
                $datos['fecha_creacion']
            );
        }
    }

    public function insertarJoyas($Joya_Codigo, $Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Mate_Id, $Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion) {
        global $pdo;
        try {
            error_log('insertarJoyas: Datos recibidos');
            if (isset($Joya_Imagen['error']) && $Joya_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/joyas/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($Joya_Imagen['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($Joya_Imagen['tmp_name'], $targetFilePath)) {
                    $Joya_Imagen = $fileName; // Guarda solo el nombre del archivo
                } else {
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                throw new Exception('Error al subir el archivo: ' . $Joya_Imagen['error']);
            }

            $sql = 'CALL SP_Joyas_insertar(:Joya_Codigo, :Joya_Nombre, :Joya_PrecioCompra, :Joya_PrecioVenta, :Joya_PrecioMayor, :Joya_Imagen, :Joya_Stock, :Prov_Id, :Mate_Id, :Cate_Id, :Joya_UsuarioCreacion, :Joya_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Codigo', $Joya_Codigo, PDO::PARAM_STR);
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
            error_log('insertarJoyas: Resultado: ' . $result);
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar joya: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al insertar joya: ' . $e->getMessage()));
            return 0;
        }
    }

    public function insertarMaquillaje($Joya_Codigo, $Joya_Nombre, $Joya_PrecioCompra, $Joya_PrecioVenta, $Joya_PrecioMayor, $Joya_Imagen, $Joya_Stock, $Prov_Id, $Cate_Id, $Joya_UsuarioCreacion, $Joya_FechaCreacion)
    {
        global $pdo;
        try {
            error_log('insertarMaquillaje: Datos recibidos');
            if (isset($Joya_Imagen['error']) && $Joya_Imagen['error'] == UPLOAD_ERR_OK) {
                $uploadDir = '../Resources/uploads/joyas/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = basename($Joya_Imagen['name']);
                $targetFilePath = $uploadDir . $fileName;
                if (move_uploaded_file($Joya_Imagen['tmp_name'], $targetFilePath)) {
                    $Joya_Imagen = $fileName; // Guarda solo el nombre del archivo
                } else {
                    throw new Exception('Error al mover el archivo subido.');
                }
            } else {
                throw new Exception('Error al subir el archivo: ' . $Joya_Imagen['error']);
            } $sql = 'CALL SP_Joyas_insertar(:Joya_Codigo, :Joya_Nombre, :Joya_PrecioCompra, :Joya_PrecioVenta, :Joya_PrecioMayor, :Joya_Imagen, :Joya_Stock, :Prov_Id, :Mate_Id, :Cate_Id, :Joya_UsuarioCreacion, :Joya_FechaCreacion)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':Joya_Codigo', $Joya_Codigo, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Nombre', $Joya_Nombre, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioCompra', $Joya_PrecioCompra, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioVenta', $Joya_PrecioVenta, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_PrecioMayor', $Joya_PrecioMayor, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Imagen', $Joya_Imagen, PDO::PARAM_STR);
            $stmt->bindParam(':Joya_Stock', $Joya_Stock, PDO::PARAM_INT);
            $stmt->bindParam(':Prov_Id', $Prov_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Cate_Id', $Cate_Id, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_UsuarioCreacion', $Joya_UsuarioCreacion, PDO::PARAM_INT);
            $stmt->bindParam(':Joya_FechaCreacion', $Joya_FechaCreacion, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetchColumn();
            error_log('insertarMaquillaje: Resultado: ' . $result);
            return $result;
        } catch (Exception $e) {
            error_log('Error al insertar maquillaje: ' . $e->getMessage());
            echo json_encode(array('error' => 'Error al insertar maquillaje: ' . $e->getMessage()));
            return 0;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $service = new FacturaCompraService();

    if ($_POST['action'] === 'listarFacturaCompras') {
        $service->listarFacturaCompras();
    } elseif ($_POST['action'] === 'buscar') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $resultado = $service->buscarFacturaCompraPorCodigo($FaCE_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'buscardetalle') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $resultado = $service->buscarFacturaDetalle($FaCE_Id);
        echo $resultado;
    } elseif ($_POST['action'] === 'listarProveedores') {
        echo $service->listarProveedores();
    } elseif ($_POST['action'] === 'listarMateriales') {
        echo $service->listarMateriales();
    } elseif ($_POST['action'] === 'listarCategorias') {
        echo $service->listarCategorias();
    } elseif ($_POST['action'] === 'listarMarcas') {
        echo $service->listarMarcas();
    } elseif ($_POST['action'] === 'listarSucursales') {
        echo $service->listarSucursales();
    } elseif ($_POST['action'] == 'insertarProducto') {
        $tipo = $_POST['tipo'];
        $datos = [
            'productoCodigo' => $_POST['productoCodigo'],
            'nombre' => $_POST['nombre'],
            'precio_compra' => $_POST['precio_compra'],
            'precio_venta' => $_POST['precio_venta'],
            'precio_mayorista' => $_POST['precio_mayorista'],
            'imagen' => $_FILES['imagen'],
            'stock' => 1,
            'proveedor' => $_POST['proveedor'],
            'material' => $_POST['Mate_Id'],
            'categoria' => $_POST['Cate_Id'],
            'usuario_creacion' => 1,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        $resultado = $service->insertarProducto($tipo, $datos);
        echo json_encode(array('result' => $resultado));
    } elseif ($_POST['action'] === 'listarJoyasAutoCompletado') {
        $term = $_POST['term'];
        echo $service->listarJoyasAutoCompletado($term);
    } elseif ($_POST['action'] === 'listarMaquillajesAutoCompletado') {
        $term = $_POST['term'];
        echo $service->listarMaquillajesAutoCompletado($term);
    } elseif ($_POST['action'] === 'buscarMaquillajePorCodigo') {
        $codigo = $_POST['codigo'];
        echo $service->buscarMaquillajePorCodigo($codigo);
    } elseif ($_POST['action'] === 'buscarJoyaPorCodigo') {
        $codigo = $_POST['codigo'];
        echo $service->buscarJoyaPorCodigo($codigo);
    } elseif ($_POST['action'] === 'insertarFacturaEncabezado') {
        $proveedor = $_POST['proveedor'];
        $sucursal = $_POST['sucursal'];
        $metodoPago = $_POST['metodoPago'];
        $usuarioCreacion = $_POST['usuarioCreacion'];
        $fechaCreacion = $_POST['fechaCreacion'];
        $resultado = $service->insertarFacturaEncabezado($proveedor, $sucursal, $metodoPago, $usuarioCreacion, $fechaCreacion);
        echo json_encode($resultado);
    } elseif ($_POST['action'] === 'insertarDetalleFactura') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];
        $precioCompra = $_POST['precioCompra'];
        $precioVenta = $_POST['precioVenta'];
        $precioMayorista = $_POST['precioMayorista'];
        $categoria = $_POST['categoria'];
        $resultado = $service->insertarDetalleFactura($FaCE_Id, $producto, $cantidad, $precioCompra, $precioVenta, $precioMayorista, $categoria);
        echo json_encode($resultado);
    } elseif ($_POST['action'] == 'obtenerFacturaCompraDetalleId') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $producto = $_POST['producto'];
        $FaCD_Dif = $_POST['FaCD_Dif'];

        $FaCD_Id = $service->obtenerFacturaCompraDetalleId($FaCE_Id, $producto, $FaCD_Dif);
        if ($FaCD_Id) {
            echo json_encode(array('success' => true, 'FaCD_Id' => $FaCD_Id));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al obtener el ID del detalle de la factura.'));
        }
    } elseif ($_POST['action'] == 'eliminarDetalleFactura') {
        $FaCD_Id = $_POST['FaCD_Id'];

        $resultado = $service->eliminarDetalleFactura($FaCD_Id);
        echo json_encode($resultado);
    } elseif ($_POST['action'] == 'finalizarFacturaCompra') {
        $FaCE_Id = $_POST['FaCE_Id'];
        $fechaFinal = $_POST['fechaFinal'];
        $resultado = $service->finalizarFacturaCompra($FaCE_Id, $fechaFinal);
        echo json_encode($resultado);
    }
}