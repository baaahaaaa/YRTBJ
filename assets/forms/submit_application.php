<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $stage = $_POST['stage'];
    $coverLetter = $_POST['cover_letter'];

    // Traitement du CV
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
        $cvTmpName = $_FILES['cv']['tmp_name'];
        $cvName = $_FILES['cv']['name'];
        $cvDest = 'uploads/' . basename($cvName);

        if (move_uploaded_file($cvTmpName, $cvDest)) {
            echo "CV téléchargé avec succès.<br>";
        } else {
            echo "Erreur lors du téléchargement du CV.<br>";
        }
    }

    // Envoi de l'email avec les détails de la candidature
    $to = "recruteur@exemple.com";  // Remplacer par l'adresse email réelle
    $subject = "Candidature pour le stage: $stage";
    $message = "Nom: $name\nEmail: $email\nTéléphone: $phone\nLettre de motivation: $coverLetter\n\nCV joint: " . $cvName;
    $headers = "From: $email";

    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        echo "Votre candidature a été envoyée par email.<br>";
    } else {
        echo "Erreur d'envoi de l'email.<br>";
    }

    // Confirmation
    echo "Merci pour votre candidature ! Nous reviendrons vers vous bientôt.";
}
?>
