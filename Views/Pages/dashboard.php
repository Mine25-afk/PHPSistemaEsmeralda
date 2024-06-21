<?php
 include 'C:\xampp\htdocs\PHPSistemaEsmeralda\Services\DashboardsService.php';
$service = new DashboardsServices();

try {
    $cantidadVentas = $service->cantidadVentas();
    $cantidadPRoducto = $service->cantidadProductos();
    $cantidadCompra = $service->cantidadCompra();
    $ClienteActivo = $service->ClientesActivos();
    // echo json_encode($ventasPorMes);
    $top5Clientes = $service->top5JClieentesActuales();
    $Caja = $service->Inciodecaja();
    if (is_array($Caja) && isset($Caja[0]['MontoInicial'])) {
      // Acceder al valor 'MontoInicial' dentro del array
      $montoInicial = $Caja[0]['MontoInicial'];
  } else {
      // En caso de no obtener un valor válido, asignar un valor por defecto
      $montoInicial = 'No disponible';
  }
    $CajaCierre = $service->CajaCierre();
    $TransaccionesReciente = $service->TransaccionesReciente();
    $EfectivoVendido = $service->EfectivoVendido();
    
    if (is_array($EfectivoVendido) && count($EfectivoVendido) > 0) {
      // Obtener el primer elemento del array
      $primerElemento = $EfectivoVendido[0];
  
      // Verificar si el primer elemento es un array asociativo y si contiene las claves necesarias
      if (is_array($primerElemento) && isset($primerElemento['MetodoPago']) && isset($primerElemento['TotalEnLempiras'])) {
          $MetodoPago = $primerElemento['MetodoPago'];
          $TotalEnLempiras = $primerElemento['TotalEnLempiras'];
      } else {
          $MetodoPago = 'No disponible';
          $TotalEnLempiras = 'No disponible';
      }
  } else {
      $MetodoPago = 'No disponible';
      $TotalEnLempiras = 'No disponible';
  }
    $VentaTarjeta = $service->VentaTarjeta();
    $primerElementoVentaTarjeta = isset($VentaTarjeta[0]) ? $VentaTarjeta[0] : null;
if ($primerElementoVentaTarjeta && is_array($primerElementoVentaTarjeta)) {
    $MetodoPagoVentaTarjeta = isset($primerElementoVentaTarjeta['MetodoPago']) ? $primerElementoVentaTarjeta['MetodoPago'] : 'No disponible';
    $TotalEnLempirasVentaTarjeta = isset($primerElementoVentaTarjeta['TotalEnLempiras']) ? $primerElementoVentaTarjeta['TotalEnLempiras'] : 'No disponible';
} else {
    $MetodoPagoVentaTarjeta = 'No disponible';
    $TotalEnLempirasVentaTarjeta = 'No disponible';
}
    $TransferenciaVentas = $service->TransferenciaVentas();
    $primerElementoTransferenciaVentas = isset($TransferenciaVentas[0]) ? $TransferenciaVentas[0] : null;
    if ($primerElementoTransferenciaVentas && is_array($primerElementoTransferenciaVentas)) {
        $MetodoPagoTransferencia = isset($primerElementoTransferenciaVentas['MetodoPago']) ? $primerElementoTransferenciaVentas['MetodoPago'] : 'No disponible';
        $TotalEnLempirasTransferencia = isset($primerElementoTransferenciaVentas['TotalEnLempiras']) ? $primerElementoTransferenciaVentas['TotalEnLempiras'] : 'No disponible';
    } else {
        $MetodoPagoTransferencia = 'No disponible';
        $TotalEnLempirasTransferencia = 'No disponible';
    }
    $ProductosMes  = $service->ProductosMes();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="card">
        <div class="row m-2">
            <!-- Tarjeta 1 -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $cantidadVentas; ?></h3>
                        <p>Datos Actuales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Ventas <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Tarjeta 2 -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $cantidadPRoducto; ?><sup style="font-size: 20px"></sup></h3>
                        <p>Datos Actuales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Productos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- Tarjeta 3 -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $cantidadCompra; ?></h3>
                        <p>Datos Actuales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Compra <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- Tarjeta 4 -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $ClienteActivo; ?></h3>
                        <p>Datos Actuales</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Cliente <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
            <div class="small-box bg-success flex-fill">
                <div class="inner">
                    <p>Inicio de Caja</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    $<?php echo $montoInicial; ?> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
            <div class="small-box bg-success flex-fill">
                <div class="inner">
                    <h4><?php echo $MetodoPago; ?></h4>
                    <p></p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    L. <?php echo $TotalEnLempiras; ?><i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
            <div class="small-box bg-success flex-fill">
                <div class="inner">
                    <h4><?php echo $MetodoPagoVentaTarjeta; ?></h4>
                    <p></p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    L. <?php echo $TotalEnLempirasVentaTarjeta; ?> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
            <div class="small-box bg-success flex-fill">
                <div class="inner">
                    <h4><?php echo $MetodoPagoTransferencia; ?></h4>
                    <p></p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="#" class="small-box-footer">
                    L. <?php echo $TotalEnLempirasTransferencia; ?><i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
        <div class="small-box card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h4 class="card-title">productos más vendidos</h4>
            </div>
            <div class="card-body">
                <ul id="top5-productos" class="list-group">
                    <?php foreach ($ProductosMes as $prod): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user"></i> <?php echo $prod['Producto']; ?></span>
                            <span class="badge badge-<?php echo isset($prod['Cantidad']) ? 'success' : 'secondary'; ?> badge-pill"><i class=""></i> <?php echo isset($prod['Cantidad']) ? $prod['Cantidad'] : 'Sin total'; ?> Total</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

        <div class="col-lg-4 col-md-6 mb-3 d-flex align-items-stretch">
            <div class="small-box bg-success flex-fill">
                <div class="inner">
                    <p>Cierre de Caja</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <a href="#" class="small-box-footer">
                    <?php 
                        if (is_array($CajaCierre) && count($CajaCierre) > 0) {
                            $json_data = $CajaCierre[0];
                            $totalMontoFinal = isset($json_data['TotalMontoFinal']) ? $json_data['TotalMontoFinal'] : 'No disponible';
                            echo '<p class="card-text">' . $totalMontoFinal . '</p>';
                        } else {
                            echo '<p class="card-text">No disponible</p>';
                        }
                    ?> <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>




    

<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white"> <!-- Cambio de bg-primary a bg-success -->
                <h3 class="card-title">Top 5 Clientes Más Vendidos</h3>
            </div>
            <div class="card-body">
                <ul id="top5-automoviles" class="list-group">
                    <?php foreach ($top5Clientes as $Cliente): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user"></i> <?php echo $Cliente['Cliente']; ?></span>
                            <span class="badge badge-<?php echo isset($Cliente['TotalCompra']) ? 'success' : 'secondary'; ?> badge-pill"><i class="fas fa-dollar-sign"></i> <?php echo isset($Cliente['TotalCompra']) ? $Cliente['TotalCompra'] : 'Sin total'; ?> Total</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white"> <!-- Cambio de bg-primary a bg-success -->
                <h3 class="card-title">Transacciones Recientes</h3>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php foreach ($TransaccionesReciente as $transaccion): ?>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <h5 class="mb-1"><i class="fas fa-file-alt mr-2"></i> Transacción N. <?php echo $transaccion['Transaccion']; ?></h5>
                                <span class="badge badge-success badge-pill"><?php echo $transaccion['Cliente']; ?></span>
                            </div>
                            <p class="mb-1"><i class="fas fa-barcode mr-2"></i> Producto: <?php echo $transaccion['ProductoCodigo']; ?></p>
                            <p class="mb-1"><i class="fas fa-shopping-cart mr-2"></i> Cantidad: <?php echo $transaccion['Cantidad']; ?> unidades</p>
                            <p class="mb-1"><i class="fas fa-dollar-sign mr-2"></i> Precio: $<?php echo $transaccion['Precio']; ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Views/Resources/plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
                      
</body>
</html>
