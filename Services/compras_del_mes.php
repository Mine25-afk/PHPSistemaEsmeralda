<?php
require_once __DIR__ . '/../config.php';
require_once 'Services/DashboardsServices.php';

try {
    $service = new DashboardsServices($pdo);
    $compras = $service->ComprasDelMes();
    echo json_encode(array('compras' => $compras));
} catch (Exception $e) {
    echo json_encode(array('error' => 'Error al obtener compras del mes: ' . $e->getMessage()));
}
?>
