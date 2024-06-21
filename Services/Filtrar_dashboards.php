<?php
require_once 'Services/DashFiltradoService.php';

header('Content-Type: application/json');

if (isset($_GET['fecha_inicio'], $_GET['fecha_fin'])) {
    $fecha_inicio = $_GET['fecha_inicio'];
    $fecha_fin = $_GET['fecha_fin'];
    $controller = new DashboardFiltradossServices(); // Aquí hay un error en el nombre de la clase
    $response = array();

    try {
        $response['cantidadComprasFiltro'] = $controller->cantidadComprasFiltro($fecha_inicio, $fecha_fin);
        $response['cantidadVentasFiltro'] = $controller->cantidadVentasFiltro($fecha_inicio, $fecha_fin);
        $response['cantidadVentasEmpleadosFiltro'] = $controller->cantidadVentasEmpleadosFiltro($fecha_inicio, $fecha_fin);
        $response['cantidadComprasClientesFiltro'] = $controller->cantidadComprasClientesFiltro($fecha_inicio, $fecha_fin);

        // Debugging: Log response before encoding to JSON
        // This helps to ensure that the response is a valid JSON object
        echo json_encode($response);
        exit();
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
        
        // Debugging: Log response with error message
        // This helps to identify any issues with the response
        echo json_encode($response);
        exit();
    }
} else {
    echo json_encode(['error' => 'Faltan parámetros de fecha.']);
    exit();
}
