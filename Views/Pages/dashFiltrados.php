<!-- 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
</head>
<style>
    /* Estilos personalizados */
/* Estilos personalizados */
.card-custom {
    border-color: #333;
    background-color: #333;
}

.bg-custom {
    background-color: #285e5a;
}
.btn-primary:hover, .btn-primary {
    background-color: #5d9e3e;
    border-color: #5d9e3e;
    color: #FFFFFF;
    background:#5d9e3e;
    
}


    </style>
<body>
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="text-center mb-4">
                <h1 class="card-title1" style="font-weight:bold; font-size: 1.8em;">Filtrar Por Fechas</h1>
            </div>
            <div class="form-row justify-content-center mt-4">
                <div class="col-md-4 mb-3">
                    <label for="startDate">Fecha de Inicio</label>
                    <input type="date" id="startDate" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="endDate">Fecha de Fin</label>
                    <input type="date" id="endDate" class="form-control">
                </div>
            </div>
            <div class="form-row justify-content-center mt-3">
                <button class="btn btn-primary filtrarFecha">Filtrar</button>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
    <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title" style="font-weight:bold">Cantidad de Productos</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="productosChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
    <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title" style="font-weight:bold">Ventas por Método de Pago</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="metodoPagoChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
    <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title" style="font-weight:bold">Compras por Género</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="generoChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-3">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title" style="font-weight:bold">Total Final de Joyas</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="joyasChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $(document).on('click', '.filtrarFecha', function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            $.ajax({
                url: 'Services/Filtrar_dashboards.php',
                method: 'GET',
                data: { 
                    fecha_inicio: startDate, 
                    fecha_fin: endDate 
                },
                dataType: 'json',
                success: function(response) {
                    processData(response);
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error al realizar la solicitud.',
                        position: 'topRight'
                    });
                    console.error('Error al realizar la solicitud:', error);
                }
            });
        });

        function processData(response) {
            // Verificar si la respuesta es un objeto JSON válido
            if (!response || typeof response !== 'object') {
                console.log(response);
                iziToast.error({
                    title: 'Error',
                    message: 'Respuesta inesperada del servidor.',
                    position: 'topRight'
                });
                console.error('Respuesta inesperada del servidor:', response);
                return;
            }

            // Lógica para procesar la respuesta y renderizar los gráficos
            // Cantidad de Productos
            if (response.productosCantidad && response.productosCantidad.length > 0) {
                var productosData = response.productosCantidad;
                var labelsProductos = productosData.map(item => item.Producto);
                var dataProductos = productosData.map(item => item.Cantidad);
                renderChart('productosChart', 'bar', labelsProductos, dataProductos, 'Cantidad de Productos');
                iziToast.success({
                    title: 'Éxito',
                    message: 'Datos de cantidad de productos cargados correctamente.',
                    position: 'topRight'
                });
            } else {
                iziToast.warning({
                    title: 'Advertencia',
                    message: 'No se encontraron datos de cantidad de productos.',
                    position: 'topRight'
                });
                console.error('Datos de cantidad de productos no encontrados');
            }

            // Ventas por Método de Pago
            if (response.ventasMetodoPago && response.ventasMetodoPago.length > 0) {
                var metodoPagoData = response.ventasMetodoPago;
                var labelsMetodoPago = metodoPagoData.map(item => item.MetodoPago);
                var dataMetodoPago = metodoPagoData.map(item => parseFloat(item.TotalEnLempiras.replace('Lps. ', '').replace(',', '')));
                renderChart('metodoPagoChart', 'pie', labelsMetodoPago, dataMetodoPago, 'Ventas por Método de Pago');
                iziToast.success({
                    title: 'Éxito',
                    message: 'Datos de ventas por método de pago cargados correctamente.',
                    position: 'topRight'
                });
            } else {
                iziToast.warning({
                    title: 'Advertencia',
                    message: 'No se encontraron datos de ventas por método de pago.',
                    position: 'topRight'
                });
                console.error('Datos de ventas por método de pago no encontrados');
            }

            // Compras por Género
            if (response.comprasGenero && response.comprasGenero.length > 0) {
                var generoData = response.comprasGenero;
                var labelsGenero = generoData.map(item => item.Genero);
                var dataGenero = generoData.map(item => item.TotalCompras);
                renderChart('generoChart', 'doughnut', labelsGenero, dataGenero, 'Compras por Género');
                iziToast.success({
                    title: 'Éxito',
                    message: 'Datos de compras por género cargados correctamente.',
                    position: 'topRight'
                });
            } else {
                iziToast.warning({
                    title: 'Advertencia',
                    message: 'No se encontraron datos de compras por género.',
                    position: 'topRight'
                });
                console.error('Datos de compras por género no encontrados');
            }

            // Total Final de Joyas
            if (response.totalFinalJoyas && response.totalFinalJoyas.length > 0) {
                var joyasData = response.totalFinalJoyas[0];  // Solo hay un resultado
                var labelsJoyas = ['Total Final'];
                var dataJoyas = [parseFloat(joyasData.TotalFinal)];
                renderChart('joyasChart', 'bar', labelsJoyas, dataJoyas, 'Total Final de Joyas');
                iziToast.success({
                    title: 'Éxito',
                    message: 'Datos del total final de joyas cargados correctamente.',
                    position: 'topRight'
                });
            } else {
                iziToast.warning({
                    title: 'Advertencia',
                    message: 'No se encontraron datos del total final de joyas.',
                    position: 'topRight'
                });
                console.error('Datos del total final de joyas no encontrados');
            }
        }

        function renderChart(elementId, type, labels, data, title) {
            var ctx = document.getElementById(elementId).getContext('2d');
            new Chart(ctx, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: title,
                        data: data,
                        backgroundColor: generateColors(data.length)
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        datalabels: {
                            anchor: 'end',
                            align: 'end',
                            formatter: function(value, context) {
                                return value > 0 ? value : '';
                            }
                        }
                    },
                    scales: type === 'bar' ? {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    } : {}
                }
            });
        }

        function generateColors(length) {
            var colors = [];
            for (var i = 0; i < length; i++) {
                colors.push('rgba(' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ',' + Math.floor(Math.random() * 255) + ', 0.5)');
            }
            return colors;
        }
    });
</script>

</body>
</html> -->
