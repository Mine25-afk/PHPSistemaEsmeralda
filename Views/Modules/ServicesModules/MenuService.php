<?php
    require_once __DIR__ . '/../../../config.php';
session_start();
class MenuService {


    public function AbrirCaja($caja_MontoInicial,$caja_UsuarioApertura,$caja_FechaApertura) {
        $caja_UsuarioApertura = 0;
        global $pdo;
        try {
            $sql = 'CALL SP_Cajas_Insertar(:caja_FechaApertura_Codigo, :Sucu_Id_Codigo, :caja_MontoInicial,:caja_UsuarioApertura)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':caja_FechaApertura_Codigo', $caja_FechaApertura, PDO::PARAM_STR);
            $stmt->bindParam(':Sucu_Id_Codigo', $_SESSION['Sucu_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':caja_MontoInicial', $caja_MontoInicial, PDO::PARAM_STR);
            $stmt->bindParam(':caja_UsuarioApertura', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }

    public function CerrarCaja($caja_FechaCierre,$caja_MontoInicial,$caja_MontoFinal,$caja_MontoSistema,$caja_Observacion,$caja_codigo) {
        global $pdo;
        try {
            $sql = 'CALL SP_Cajas_Cierre(:caja_UsuarioCierre, :caja_FechaCierre, :caja_MontoInicial,:caja_MontoFinal,:caja_MontoSistema,:caja_Observacion,:caja_codigo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':caja_UsuarioCierre', $_SESSION['Usua_Id'], PDO::PARAM_INT);
            $stmt->bindParam(':caja_FechaCierre', $caja_FechaCierre, PDO::PARAM_STR);
            $stmt->bindParam(':caja_MontoInicial', $caja_MontoInicial, PDO::PARAM_STR);
            $stmt->bindParam(':caja_MontoFinal', $caja_MontoFinal, PDO::PARAM_STR);
            $stmt->bindParam(':caja_MontoSistema', $caja_MontoSistema, PDO::PARAM_STR);
            $stmt->bindParam(':caja_Observacion', $caja_Observacion, PDO::PARAM_STR);
            $stmt->bindParam(':caja_codigo', $caja_codigo, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }


    public function RetiroDinero($cadi_Dinero,$cadi_Observaciones,$FechaHoy) {
        global $pdo;
        try {
            $sql = 'CALL SP_CajaPorDinero_Insertar(:cadi_Dinero, :cadi_Observaciones, :FechaHoy,:cadi_Usuario)';
            $stmt = $pdo->prepare($sql);
       
            $stmt->bindParam(':cadi_Dinero', $cadi_Dinero, PDO::PARAM_STR);
            $stmt->bindParam(':cadi_Observaciones', $cadi_Observaciones, PDO::PARAM_STR);
            $stmt->bindParam(':FechaHoy', $FechaHoy, PDO::PARAM_STR);
            $stmt->bindParam(':cadi_Usuario', $_SESSION['Usua_Id'], PDO::PARAM_INT);

            $stmt->execute();
            
            $result = $stmt->fetchColumn();
            return $result; // 1 si es exitoso, 0 si no
        } catch (PDOException $e) {
            return 0; // Retornar 0 en caso de error
        }
    }


}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    require_once __DIR__ . '/../../../config.php';
    $controller = new MenuService();

  if ($_POST['action'] === 'insertar') {
        $caja_MontoInicial = $_POST['caja_MontoInicial'];
        $caja_UsuarioApertura = $_POST['caja_UsuarioApertura'];
        $caja_FechaApertura = $_POST['caja_FechaApertura'];
        $resultado = $controller->AbrirCaja($caja_MontoInicial,$caja_UsuarioApertura,$caja_FechaApertura);
        echo $resultado;
    }
    elseif ($_POST['action'] === 'cerrar') {
        $caja_FechaCierre = $_POST['caja_FechaCierre'];
        $caja_MontoInicial = $_POST['caja_MontoInicial'];
        $caja_MontoFinal = $_POST['caja_MontoFinal'];
        $caja_MontoSistema = $_POST['caja_MontoSistema'];
        $caja_Observacion = $_POST['caja_Observacion'];
        $caja_codigo = $_POST['caja_codigo'];
        $resultado = $controller->CerrarCaja($caja_FechaCierre,$caja_MontoInicial,$caja_MontoFinal,$caja_MontoSistema,$caja_Observacion,$caja_codigo);
        echo $resultado;
    } elseif ($_POST['action'] === 'retiro') {
        $cadi_Dinero = $_POST['cadi_Dinero'];
        $cadi_Observaciones = $_POST['cadi_Observaciones'];
        $FechaHoy = $_POST['FechaHoy'];
        $resultado = $controller->RetiroDinero($cadi_Dinero,$cadi_Observaciones,$FechaHoy);
        echo $resultado;
    }
}

?>