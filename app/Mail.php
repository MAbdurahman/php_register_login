<?php

    namespace app;


    //Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
    use \PHPMailer\PHPMailer\PHPMailer;
    use \PHPMailer\PHPMailer\SMTP;
    use \PHPMailer\PHPMailer\Exception;


    /**
     * Mail Class -
     * PHP version 8.0.13
     */
    class Mail
    {
        /**
         * send Function - sends a message
         * @param string $to Recipient
         * @param string $subject Subject
         * @param string $text Text-only content of the message
         * @param string $html HTML content of the message
         *
         * @return mixed
         */
        public static function send($to, $subject, $text, $html)
        {
            //Create an instance; passing `true` enables exceptions
            $mail = new \PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_ENV['HOST'];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = $_ENV['USERNAME'];                     //SMTP username
                $mail->Password   = $_ENV['PASSWORD'];                               //SMTP password
//           $mail->SMTPSecure = \PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = $_ENV['PORT'];                                    //TCP port to connect to; use 587
                // if you
                // have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('pleasereply@domain.com', 'PHP Register/Login');
                $mail->addAddress($to);     //Add a recipient
//                $mail->addAddress('ellen@example.com');               //Name is optional
                $mail->addReplyTo($_ENV['USERNAME'], 'Mahdi');
//                $mail->addCC('cc@example.com');
//                $mail->addBCC('bcc@example.com');

                //Attachments
//                $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $html;
                $mail->AltBody = $text;

                $mail->send();

                echo 'Email has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }//end of the send Function

    }//end of the Mail Class