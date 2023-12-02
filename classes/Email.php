<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $email;
    public $nombre;
    public  $token;

    public function __construct($email,$nombre, $token){

        $this->email =$email;
        $this->nombre =$nombre;
        $this->token =$token;
    }
    
    public function enviarConfirmacion(){

        //Crear una instancia de PHPMailer

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host='smtp.gmail.com'; //'sandbox.smtp.mailtrap.io'; //$_ENV['EMAIL_HOST'];
        $mail->SMTPAuth=true;
        $mail->Username = 'keypressoft@gmail.com'; //'185bff50cb688d' ; //$_ENV['USER'];
        $mail->Password = 'ooupzmgfmcpctafc'; //'6b9eb88b3fca03'; //$_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port=587; //2525; //$_ENV['PORT'];

        //Configurar el contenido del mail
        $mail->setFrom($this->email);
        $mail->addAddress($this->email,'Sistema Web');
        $mail->Subject = 'Confirma tu Cuenta';
       
        //Habilitas HTML
        $mail->isHTML(true);
        $mail->CharSet='UTF-8';

        //Definir el Contenido
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has creado tu cuenta en Sistema Web, sólo debes confirmarla presionando el siguiente enlace.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .="</html>";

        $mail->Body=$contenido;
        
        //Enviar el mail

        $mail->send();
    }

    public function enviarInstrucciones(){

        //Crear una instancia de PHPMailer

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host='smtp.gmail.com'; //'sandbox.smtp.mailtrap.io'; //$_ENV['EMAIL_HOST'];
        $mail->SMTPAuth=true;
        $mail->Username = 'keypressoft@gmail.com'; //'185bff50cb688d' ; //$_ENV['USER'];
        $mail->Password = 'ooupzmgfmcpctafc'; //'6b9eb88b3fca03'; //$_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port=587; //2525; //$_ENV['PORT'];

        //Configurar el contenido del mail
        $mail->setFrom($this->email);
        $mail->addAddress($this->email,'Sistema Web');
        $mail->Subject = 'Reestablece tu Password';
       
        //Habilitas HTML
        $mail->isHTML(true);
        $mail->CharSet='UTF-8';

        //Definir el Contenido
        $contenido = '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>. Has solicitado reestablecer tu Password. Sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .="<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje.</p>";
        $contenido .="</html>";

        $mail->Body=$contenido;
        
        //Enviar el mail

        $mail->send();
    }
}