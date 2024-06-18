<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Services/MarcaService.php';

$controller = new MarcaController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'insertar' && isset($_POST['Marca'])) {
        $nombre = $_POST['Marca'];
        try {
            $resultado = $controller->insertarMarca($nombre,$Marc_Id, $Marc_UsuarioCreacion, $Marc_FechaCreacion);
            echo json_encode(['status' => $resultado ? 'success' : 'error']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
?>