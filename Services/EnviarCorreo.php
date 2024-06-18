<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

session_start();


function enviarCorreo($verificationCode) {
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
        $mail->Port       = 587;                                   // Puerto TCP para conectar

      
        $mail->setFrom('enriquebarahonayt14@gmail.com', 'Hector');
        

        $emails = listarCorreosAdministradores(); 
        if (isset($emails['error'])) {
            echo json_encode($emails); 
            return;
        }

        foreach ($emails as $email) {
            if (!empty($email['Empl_Correo'])) {
                $mail->addAddress($email['Empl_Correo']);  
            }
        }

  
        $mail->isHTML(true);                                  
        $mail->Subject = 'Verificacion de Codigo';
        $mail->Body    = 'Ingrese el código para habilitar al Cliente Mayorista: ' . $verificationCode;

      
        $mail->send();
        echo 'Enviado correctamente. Código de verificación: ' . $verificationCode;
    } catch (Exception $e) {
        echo "Error al enviar: {$mail->ErrorInfo}";
    }
}

function listarCorreosAdministradores() {
    global $pdo;

    try {
        $sql = 'CALL SP_Empleados_CorreosAdministradores()';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;  
    } catch (Exception $e) {
        error_log('Error al listar correos de administradores: ' . $e->getMessage());
        return array('error' => 'Error al listar Correos: ' . $e->getMessage());
    }
}


$verificationCode = rand(100000, 999999);


$_SESSION['verification_code'] = $verificationCode;


enviarCorreo($verificationCode);
?>
