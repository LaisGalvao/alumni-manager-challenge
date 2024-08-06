<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController extends Controller
{

    public function sendEmail($email, $param){
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->CharSet = "utf-8";
            $mail->Host       = $email['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $email['username'];
            $mail->Password   = $email['password'];
            $mail->SMTPSecure = $email['encryption'];
            $mail->Port       = $email['port'];
            $mail->setFrom($email['username'], $param['name']);
            $mail->addAddress($param['userEmail']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $param['subject'];
            $mail->Body    =  $param['body'];
            $mail->send();

            return response('Message has been sent', 200);
        } catch (Exception $e) {
            return response('Message could not be sent. Mailer Error: {$mail->ErrorInfo}', 400);
        }
    }
}
