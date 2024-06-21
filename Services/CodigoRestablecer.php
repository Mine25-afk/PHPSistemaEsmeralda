<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoIngresado = $_POST['codigo'];
    $codigoGenerado = isset($_SESSION['verification_code']) ? $_SESSION['verification_code'] : '';

    if ($codigoIngresado == $codigoGenerado) {
        echo json_encode(array('valid' => true));
    } else {
        echo json_encode(array('valid' => false));
    }
} else {
    http_response_code(405); 
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
