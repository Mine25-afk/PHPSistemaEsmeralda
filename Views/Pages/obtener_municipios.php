<?php
require_once 'Controllers/MunicipioController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['Depa_Codigo'])) {
        $Depa_Codigo = $_POST['Depa_Codigo'];
        $muni = new MunicipioController();
        try {
            $municipios = $muni->listarMunicipiosPorDepartamento($Depa_Codigo);
            header('Content-Type: application/json');
            echo json_encode($municipios);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }
}
?>
