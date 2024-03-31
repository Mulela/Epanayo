<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Charger l'autoloader de Composer
require 'vendor/autoload.php';

// Traitement de la requête AJAX pour l'envoi du formulaire de contact
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les données du formulaire
  $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
  $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $interesser = isset($_POST['interesser']) ? $_POST['interesser'] : '';
  $parcelle = isset($_POST['parcelle']) ? $_POST['parcelle'] : '';
  $commune = isset($_POST['commune']) ? $_POST['commune'] : '';
  $type = isset($_POST['type']) ? $_POST['type'] : '';
  $dossier = isset($_POST['dossier']) ? $_POST['dossier'] : '';
  $message = isset($_POST['message']) ? $_POST['message'] : '';

  // Insertion dans la base de données ou envoi par e-mail, selon le cas
  if (!empty($nom) && !empty($telephone) && !empty($email) && !empty($interesser) && !empty($parcelle) && !empty($commune) && !empty($type) && !empty($dossier)) {
    try {
      // Créer une instance de PHPMailer
      $mail = new PHPMailer(true);
      // Spécifier l'encodage des caractères
      $mail->CharSet = 'UTF-8';

      // Paramètres du serveur SMTP
      $mail->isSMTP();
      $mail->Host = 'sxb1plzcpnl453514.prod.sxb1.secureserver.net';
      $mail->SMTPAuth = true;
      $mail->Username = 'info@epanayo.co';
      $mail->Password = 'epanayo2005';
      $mail->SMTPSecure = 'ssl'; // Utilisez 'ssl' au lieu de 'tls' pour le port SMTP 465
      $mail->Port = 465; // SMTP Port 465


      // Destinataires
      $mail->setFrom($email, $nom);
      $mail->addAddress('info@epanayo.co', 'Epanayo');

      // Contenu de l'e-mail
      $mail->isHTML(true);
      $mail->Subject = "Contact EPANAYO";
      $mail->Body = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f2f2f2;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #ffffff;
                padding: 20px;
                border: 1px solid #dddddd;
            }
            .header {
                text-align: center;
                padding-bottom: 20px;
            }
            .header img {
                max-width: 150px;
            }
            .content {
                padding: 20px 0;
            }
            .content h2 {
                color: #333333;
                font-size: 18px;
                margin-bottom: 15px;
                text-decoration: underline;
            }
            .field {
                margin-bottom: 10px;
            }
            .field label {
                font-weight: bold;
                display: inline-block;
                width: 150px;
            }
            .field-value {
                margin-left: 160px;
            }
            .footer {
                text-align: center;
                color: #777777;
                font-size: 12px;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <img src='https://i.imgur.com/IhjMOty.png' alt='Logo EPANAYO'>
            </div>
            <div class='content'>
                <h2>Informations du formulaire</h2>
                <div class='field'>
                    <label>Nom :</label>
                    <span class='field-value'>$nom</span>
                </div>
                <div class='field'>
                    <label>Téléphone :</label>
                    <span class='field-value'>$telephone</span>
                </div>
                <div class='field'>
                    <label>Email :</label>
                    <span class='field-value'>$email</span>
                </div>
                <div class='field'>
                    <label>Intéressé :</label>
                    <span class='field-value'>$interesser</span>
                </div>
                <div class='field'>
                    <label>Parcelle :</label>
                    <span class='field-value'>$parcelle</span>
                </div>
                <div class='field'>
                    <label>Commune :</label>
                    <span class='field-value'>$commune</span>
                </div>
                <div class='field'>
                    <label>Type de maison :</label>
                    <span class='field-value'>$type</span>
                </div>
                <div class='field'>
                    <label>Ouvrir le dossier :</label>
                    <span class='field-value'>$dossier</span>
                </div>
                <hr>
                <div class='field'>
                    <label>Message :</label>
                    <span class='field-value'>$message</span>
                </div>
            </div>
            <div class='footer'>
                Ce message a été envoyé depuis le site web d' <a href'https://www.epanayo.co'>E P A N A Y O</a>.
            </div>
        </div>
    </body>
    </html>
";





      // Répondre avec un message de succès
      echo json_encode(['success' => true, 'message' => $mail->send()]);
      exit;
    } catch (Exception $e) {
      // Répondre avec un message d'erreur
      echo json_encode(['success' => false, 'error' => 'Une erreur s\'est produite lors de l\'envoi de l\'e-mail, veuillez réessayer.' . $mail->ErrorInfo]);
      exit;
    }
  } else {
    // Répondre avec un message d'erreur si un champ est vide
    echo json_encode(['success' => false, 'error' => 'Les champs ne peuvent pas être vides.']);
    exit;
  }
}
