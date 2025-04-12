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
    public static function sendMailToPassagers($to, $subject, $templateMail, $params)
    {
        // Instantiation de la classe PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            // Envoyer le mail via SMTP
            $mail->SMTPAuth   = true;                                   // Activer l'authentification SMTP
            $mail->Host       = 'smtp.gmail.com';                       // Spécifier le host SMTP
            $mail->Username   = 'testecoride8@gmail.com';               //SMTP username
            $mail->Password   = 'xnmrbjihoerwprhl';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Activer le cryptage TLS;
            $mail->Port       = 587;                                    // Port TCP à utiliser pour la connexion


            // Expediteur et Destinataire
            $mail->setFrom('testecoride8@gmail.com', 'EcoRide');       // Qui ENVOIE le mail
            $mail->addAddress($to, 'Passager');                          // Qui REÇOIT le mail

            // Encodage
            $mail->CharSet = 'UTF-8'; 
            $mail->Encoding = 'base64';

            //Content
            $mail->isHTML(true);                                  // Activer le format HTML
            $mail->Subject = $subject;                             // Sujet du mail

            // Chemin du modèle du mail
            $templatePath = _ROOTPATH_ . "/Templates/Mails/" . $templateMail;

            // Exécution de PHP dans le fichier template
            ob_start();
            extract($params);  // Extraire les variables du tableau params
            include $templatePath; // Inclure le fichier template (le code PHP sera exécuté)
            $content = ob_get_clean(); // Récupérer le contenu du fichier template

            // Le contenu du mail
            $mail->Body = $content;

            // Envoi du mail
            $mail->send();
        } catch (Exception $e) {
            echo "Error dans l'envoie du mail. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
