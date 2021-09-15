<?php

namespace  models\class\module;

require "./api/PHPmailer/Email/Exception.php";
require "./api/PHPmailer/Email/OAuth.php";
require "./api/PHPmailer/Email/PHPMailer.php";
require "./api/PHPmailer/Email/POP3.php";
require "./api/PHPmailer/Email/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use models\class\module\cadastroUsuario;
use app\pages\cadastro;

class sendEmail{
    private $nome;
    private $email;
    private $token;

    public function __construct(
        private $nome,
        private $email,
        private $token,
    ){

        $this->nome = $nome;
        $this->email = $email;
        $this->token = null;
    }

    public function EnviaEmail(string $emailSupport, string $emailUser, string $token){
        private $from = $this->emailSupport;
        private $to = $this->emailUser;
        private $token = $this->token;
        private $mensagem = ""

        $validaDado = new validaDados($to,$token,$mensagem);

        if($validaDado == true){
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'user@example.com';                     //SMTP username
                $mail->Password   = 'secret';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('from@example.com', 'Mailer');
                $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                $mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');

                //Attachments
                $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                echo 'Message has been sent';
            }catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
      
    public validaDados(string $email, string $token, string $mensagem){
        if(empty($this->email) || empty($this->token) || empty($this->mensagem)){
            return false;
        }

        return true;
    }
}
?>
