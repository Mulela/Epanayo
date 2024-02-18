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
      // Paramètres du serveur SMTP
      $mail->isSMTP();
      $mail->Host = 'mail.esikanayo.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'info@esikanayo.com';
      $mail->Password = 'esikanayo2005';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      // Destinataires
      $mail->setFrom('noreply@esikanayo.com', 'esikanayo');
      $mail->addAddress('info@esikanayo.com', 'esikanayo');

      // Contenu de l'e-mail
      $mail->isHTML(true);
      $mail->Subject = "Contact EPANAYO";
      $mail->Body = "<html><body><h2>Informations du formulaire :</h2><p><strong>Nom :</strong> $nom</p><p><strong>Téléphone :</strong> $telephone</p><p><strong>Email :</strong> $email</p><p><strong>Intéressé :</strong> $interesser</p><p><strong>Parcelle :</strong> $parcelle</p><p><strong>Commune :</strong> $commune</p><p><strong>Type de maison :</strong> $type</p><p><strong>Ouvrir le dossier :</strong> $dossier</p><hr><p><strong>Message :</strong><br>$message</p></body></html>";

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
?>