<?php
require_once __DIR__ . '/../config.php';

class LoginService {


    public function InicioSesion($Usuario, $Contra) {

        global $pdo;
        try {
            $sql = 'CALL SP_Usuarios_inicioSesion(:p_Usuario, :p_Contra)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':p_Usuario', $Usuario, PDO::PARAM_STR);
            $stmt->bindParam(':p_Contra', $Contra, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode(array('data' => $result));
        } catch (PDOException $e) {
            return 0; 
        }
    }

}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../config.php';
    session_start();
    $controller = new LoginService();
   
    if ($_POST['action'] === 'Login') {
        $Usuario = $_POST['Usuario'];
        $Contra = $_POST['Contra'];
        $resultado = $controller->InicioSesion($Usuario,$Contra);
        $data = json_decode($resultado, true); 
        if (!empty($data) && isset($data['data'][0])) {
            $user = $data['data'][0]; 
            $_SESSION['Usua_Id'] = $user['Usua_Id'];
            $_SESSION['Usua_Usuario'] = $user['Usua_Usuario'];
            $_SESSION['Empl_Nombre'] = $user['Empl_Nombre'];
            $_SESSION['Empl_Id'] = $user['Empl_Id'];
            $_SESSION['Role_Id'] = $user['Role_Id'];
            $_SESSION['Usua_Administrador'] = $user['Usua_Administrador'];
            $_SESSION['Sucu_Id'] = $user['Sucu_Id'];
            $_SESSION['Sucu_Nombre'] = $user['Sucu_Nombre'];
            $_SESSION['Role_Rol'] = $user['Role_Rol'];
            $_SESSION['Empl_Correo'] = $user['Empl_Correo'];
        }
        echo $resultado;
    } 
}

?>