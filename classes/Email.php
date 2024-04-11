<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this-> token = $token;
    }

    public function enviarConfirmacion() {
        
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@motoescuela.com');
        $mail->addAddress('cuentas@motoescuela.com', 'motoescuela.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Enviar el mail
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido  .= "<p><strong>Hola " .$this->nombre . "</strong> Has creado tu cuenta
        en MotoEscuela, solo debes confirmarla presionando el sigueinte enlace</p>";
        $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token="
         . $this->token . "'>Confirmar Cuenta</a></p>";
         $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= "</html>";
         $mail->Body = $contenido;

         // Enviar el email
         $mail->send();
    }

    public function enviarInstrucciones() {
        
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@motoescuela.com');
        $mail->addAddress('cuentas@motoescuela.com', 'motoescuela.com');
        $mail->Subject = 'Restablece tu Contraseña';

        // Enviar el mail
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido  .= "<p><strong>Hola " .$this->nombre . "</strong> Has solicitado reestablecer 
        tu Contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token="
         . $this->token . "'>Reestablecer Contraseña</a></p>";
         $contenido .= "<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>";
         $contenido .= "</html>";
         $mail->Body = $contenido;

         // Enviar el email
         $mail->send();
    }
}
?>