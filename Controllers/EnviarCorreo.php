<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

class EnviarCorreo {
    public function listarCorreosAdministradores() {
        global $pdo;
        try {
            $sql = 'CALL SP_Empleados_CorreosAdministradores()';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;  
        } catch (Exception $e) {
            error_log('Error al listar clientes: ' . $e->getMessage());
            return array('error' => 'Error al listar Correos: ' . $e->getMessage());
        }
    }

    public function enviarCorreoVerificacion() {
        $mail = new PHPMailer(true);
        $verificationCode = rand(100000, 999999);

        try {
            // Server settings
            $mail->SMTPDebug = 0;                      // Disable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;  
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable SMTP authentication
            $mail->Username   = 'enriquebarahonayt14@gmail.com';       // SMTP username
            $mail->Password   = 'fulu kzft lgts kvte';                 // SMTP password
            $mail->Port       = 587;                                   // TCP port to connect to

            // Recipients
            $mail->setFrom('enriquebarahonayt14@gmail.com', 'Hector');
            
            $emails = $this->listarCorreosAdministradores(); 
            if (isset($emails['error'])) {
                echo json_encode($emails); 
                return;
            }
            foreach ($emails as $email) {
                if (!empty($email['Empl_Correo'])) {
                    $mail->addAddress($email['Empl_Correo']);  
                }
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Verificacion de Codigo';
            $mail->Body    = 'Ingrese el código para habilitar al Cliente Mayorista: ' . $verificationCode;

            $mail->send();
            echo 'Enviado correctamente. Código de verificación: ' . $verificationCode;
        } catch (Exception $e) {
            echo "Error al enviar: {$mail->ErrorInfo}";
        }
    }
}


$correo = new EnviarCorreo();
$correo->enviarCorreoVerificacion();
?>