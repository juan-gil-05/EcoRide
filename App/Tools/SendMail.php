<?php

namespace App\Tools;

// Importation de la classe PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Importation l'autoload de composer
require 'vendor/autoload.php';


class SendMail
{
    public static function sendMailToPassagers($to, $subject, $message)
    {
        // Instantiation de la classe PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            // Envoyer le mail via SMTP
            $mail->SMTPAuth   = true;                                   // Activer l'authentification SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Spécifier le host SMTP
            $mail->Username   = 'testecoride8@gmail.com';               //SMTP username
            $mail->Password   = 'xnmrbjihoerwprhl';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Activer le cryptage TLS;
            $mail->Port       = 587;                                    // Port TCP à utiliser pour la connexion


            // Expediteur et Destinataire
            $mail->setFrom('testecoride8@gmail.com', 'Chauffeur');       // Qui ENVOIE le mail
            $mail->addAddress('testecoride8@gmail.com', 'Passager');     // Qui REÇOIT le mail


            //Content
            $mail->isHTML(true);                                  // Activer le format HTML
            $mail->Subject = 'Annulation de votre covoiturage';   // Sujet du mail

            // Lire le contenu du fichier mail.html
            $file = fopen('mail.html', 'r'); // ouvrir le fichier
            $content = fread($file, filesize('mail.html')); // lire le fichier
            $content = trim($content); // supprimer les espaces
            fclose($file); // fermer le fichier

            $mail->Body = $content;

            $mail->send();
            echo 'Message envoyé';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
