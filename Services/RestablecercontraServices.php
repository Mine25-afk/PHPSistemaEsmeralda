<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

session_start();

class RestablecerContraServices {

    public function enviarCodigo($p_Correo) {
        global $pdo;
        try {
            $correoUsuario = $this->obtenerCorreoUsuario($p_Correo);
            
            if ($correoUsuario === "2") {
                return json_encode(array('status' => 'error', 'message' => 'Usuario o correo no encontrado.'));
            }

            $codigoVerificacion = $this->generarCodigoVerificacion();
            $_SESSION['verification_code'] = $codigoVerificacion;

            $this->enviarCorreo($correoUsuario, $codigoVerificacion, 'Código de Verificación', 'Su código de verificación es: ' . $codigoVerificacion);

            return json_encode(array('status' => 'success', 'message' => 'Código enviado correctamente.'));
        } catch (PDOException $e) {
            error_log('Error al enviar el código: ' . $e->getMessage());
            return json_encode(array('status' => 'error', 'message' => 'Error al enviar el código.'));
        }
    }

    public function restablecerContra($p_Correo, $p_NuevaContrasena) {
        global $pdo;
        try {
            $sql = 'CALL SP_RestablecerContrasena(:p_Correo, :p_NuevaContrasena)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':p_Correo', $p_Correo, PDO::PARAM_STR);
            $stmt->bindParam(':p_NuevaContrasena', $p_NuevaContrasena, PDO::PARAM_STR);
            $stmt->execute();
    
            return json_encode(array('status' => 'success', 'message' => 'Contraseña restablecida correctamente.'));
        } catch (PDOException $e) {
            error_log('Error al restablecer la contraseña: ' . $e->getMessage());
            return json_encode(array('status' => 'error', 'message' => 'Error al restablecer la contraseña.'));
        }
    }
    

    private function obtenerCorreoUsuario($usuarioCorreo) {
        global $pdo;
        try {
            $sql = 'CALL SP_ObtenerCorreoUsuarioRestablecerContra(:input_usuario_or_correo)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':input_usuario_or_correo', $usuarioCorreo, PDO::PARAM_STR);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result && $result['Resultado'] == 1) {
                return $result['Correo'];
            } else {
                return "2"; 
            }
        } catch (PDOException $e) {
            error_log('Error al obtener el correo del usuario: ' . $e->getMessage());
            return "2"; 
        }
    }

    private function enviarCorreo($correo, $contenido, $asunto, $mensaje) {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;                      // Desactivar salida de depuración verbose
            $mail->isSMTP();                                            // Enviar usando SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Configurar el servidor SMTP
            $mail->SMTPAuth   = true;  
            $mail->SMTPSecure = 'tls';   
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Habilitar autenticación SMTP
            $mail->Username   = 'enriquebarahonayt14@gmail.com';       // Nombre de usuario SMTP
            $mail->Password   = 'fulu kzft lgts kvte';                 // Contraseña SMTP
            $mail->Port       = 587;                        

            $mail->setFrom('enriquebarahonayt14@gmail.com', 'Hector');
            $mail->addAddress($correo);                                

            $mail->isHTML(true);                                      
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
        } catch (Exception $e) {
            error_log('Error al enviar el correo: ' . $mail->ErrorInfo);
        }
    }

    private function generarCodigoVerificacion() {
        return rand(1000, 9999); 
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $service = new RestablecerContraServices();

    if ($action === 'sendCode') {
        $user = $_POST['user'];
        echo $service->enviarCodigo($user);
    } elseif ($action === 'resetPassword') {
        $user = $_POST['user'];
        $password = $_POST['password'];
        echo $service->restablecerContra($user, $password);
    } else {
        http_response_code(400);
        echo json_encode(array('error' => 'Acción no válida.'));
    }
} else {
    http_response_code(405);
    echo json_encode(array('error' => 'Método no permitido.'));
}
