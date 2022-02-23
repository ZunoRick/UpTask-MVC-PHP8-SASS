<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '6183892eb1c76b';
        $mail->Password = 'dc76e9e4748836';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'UpTask.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> has creado tu cuenta en uptask, sólo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://". $_SERVER["HTTP_HOST"] . "/confirmar?token=".$this->token."'>Confirmar Cuenta</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '6183892eb1c76b';
        $mail->Password = 'dc76e9e4748836';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@uptask.com');
        $mail->addAddress('cuentas@uptask.com', 'UpTask.com');
        $mail->Subject = 'Reestablece tu password';

        //Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para continuar.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://". $_SERVER["HTTP_HOST"] ."/reestablecer?token=".$this->token."'>Reestablecer Password</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el mail
        $mail->send();
    }
}