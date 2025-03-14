<?php
namespace App\Model;
use PDO;
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Usuario extends Model {
    protected $table = 'usuario';

    public function __construct(PDO $con) {
        parent::__construct($con);
    }

    public function cargarUsuario($con, $correo) {
        $stmt = $con->prepare("SELECT id_usuario, contrasenia, validado FROM usuario WHERE correo = :correo");
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function enviarCorreoValidacion($email, $codigo) {
        $mail = new PHPMailer(true);

        try {
            // Cargar variables del .env
            $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2)); // Sube dos niveles hasta la raíz
            $dotenv->load();


            $mail->isSMTP();
            $mail->Host = 'smtp.mailjet.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAILJET_USERNAME'];
            $mail->Password = $_ENV['MAILJET_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $asunto = "Confirma tu cuenta";
            $mensaje = "Hola,\n\nPara activar tu cuenta, haz clic en el siguiente enlace:\n";
            $mensaje .= "http://localhost:8080/validate?codigo=" . urlencode($codigo) . "\n\n";
            $mensaje .= "Si no solicitaste esta cuenta, ignora este mensaje.";

            $mail->setFrom('kekeprotoraturanafuresu@gmail.com', 'Your Website');
            $mail->addAddress($email);

            $mail->isHTML(false);
            $mail->Subject = $asunto;
            $mail->Body    = $mensaje;

            $mail->send();
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $mail->ErrorInfo);
        }
    }

    public function buscarCodigo($con, $codigo) {
        $stmt = $con->prepare("SELECT 1 FROM usuario WHERE codigovalidacion = :codigo AND validado = 0 LIMIT 1");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

    public function validarUsuario($con, $codigo) {
        $stmt = $con->prepare("UPDATE usuario SET validado = 1 WHERE codigovalidacion = :codigo");
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
    }

    public function buscarEmail($con, $email) {
        $stmt = $con->prepare("SELECT 1 FROM usuario WHERE correo = :correo LIMIT 1");
        $stmt->bindParam(':correo', $email);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

}

?>
