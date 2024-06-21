<?php
 include 'C:\xampp\htdocs\PHPSistemaEsmeralda\Services\DashboardsService.php';
$service = new DashboardsServices();

try {
    $cantidadVentas = $service->cantidadVentas();
    $cantidadPRoducto = $service->cantidadProductos();
    $cantidadCompra = $service->cantidadCompra();
    $ClienteActivo = $service->ClientesActivos();
    // echo json_encode($ventasPorMes);
    $topProductos = $service->top5Joyas();

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>


      <!-- CANTIDADES -->
       <div class="card">       
      <div class="row m-2">
      <div class="col-lg-3 col-6">
            <!-- small box -->
            
            <div class="small-box bg-info">
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
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $cantidadPRoducto; ?><sup style="font-size: 20px"></sup></h3>

                <p>Datos Actuales</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">Productos<i ></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            
            <div class="small-box bg-info">
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
          <!-- ./col -->
          
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $ClienteActivo; ?></h3>

                <p>Datos Actuales</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="#" class="small-box-footer">
              Cliente<i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
     
        </div>
        </div>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>


        <div class="row m-2">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Top 5 Joyas Mas Vendidas</h3>
            </div>
            <div class="card-body">
                <ul id="top5-automoviles" class="list-group">
                    <?php foreach ($topProductos as $marca): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fa-shopping-cart"></i> <?php echo $marca['Producto']; ?></span>
                            <span class="badge badge-primary badge-pill"><?php echo $marca['Cantidad']; ?> unidades</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

        <script src="../Views/Resources/plugins/jquery/jquery.min.js"></script>
        <script src="../Views/Resources/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>