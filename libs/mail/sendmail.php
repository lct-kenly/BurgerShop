<?php

    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    class Mailler {
        public function sendmail($Data) {
            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer(true);
            
            try {
                $mail->CharSet = 'utf8';
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF;// Enable verbose debug output
                $mail->isSMTP();// gửi mail SMTP
                $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
                $mail->SMTPAuth = true;// Enable SMTP authentication
                $mail->Username = 'thanh.ledah@gmail.com';// SMTP username
                $mail->Password = 'xiyrrbrtmybkhxzn'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; 
                $mail->Port = 587; // TCP port to connect to

                //Recipients
                $mail->setFrom('thanh.ledah@gmail.com', 'FEANE');

                $mail->addAddress($Data['email']); // Add a recipient
                $mail->addAddress('thanh.ledah@gmail.com'); // Name is optional


                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                // Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

                // Content
                $mail->isHTML(true);   // Set email format to HTML
                $mail->Subject = 'Xác nhận đặt bàn của khách hàng ' . $Data['fullname'];
                $mail->Body = '<div>
                                    <p> Tên khách hàng: ' .$Data['fullname']. ' </p>
                                    <p> Email: ' .$Data['email']. ' </p>
                                    <p> Số điện thoại: ' .$Data['phone']. ' </p>
                                    <p> Số người: ' .$Data['person']. ' </p>
                                    <p> Ngày đặt: ' .$Data['date']. ' </p>
                               </div>';

                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
                
        }
    }

?>