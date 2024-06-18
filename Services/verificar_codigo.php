<?php
session_start();

// Comprobamos si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos el código ingresado desde la solicitud AJAX
    $codigoIngresado = $_POST['codigo'];

    // Suponemos que el código generado previamente está almacenado en una variable de sesión
    $codigoGenerado = $_SESSION['verification_code'];

    // Verificamos si el código ingresado coincide con el código generado
    if ($codigoIngresado == $codigoGenerado) {
        echo json_encode(array('valid' => true));
    } else {
        echo json_encode(array('valid' => false));
    }
} else {
    // Si no es una solicitud POST, devolvemos un error
    http_response_code(405); // Método no permitido
    echo json_encode(array('error' => 'Método no permitido'));
}
?>
