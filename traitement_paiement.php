<?php
// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et sécurisation des données
    $numero_carte = htmlspecialchars(trim($_POST["numero_carte"]));
    $nom_carte = htmlspecialchars(trim($_POST["nom_carte"]));
    $expiration = htmlspecialchars(trim($_POST["expiration"]));
    $cvc = htmlspecialchars(trim($_POST["cvc"]));

    // Format de la ligne à enregistrer
    $ligne = "Numéro: $numero_carte | Nom: $nom_carte | Expiration: $expiration | CVC: $cvc\n";

    // Enregistrement dans un fichier texte
    $fichier = 'paiements.txt';
    if (file_put_contents($fichier, $ligne, FILE_APPEND | LOCK_EX)) {
        echo "<h2>Paiement enregistré avec succès.</h2>";
        Header("Location:liste_reservation.php");
    } else {
        echo "<h2>Erreur lors de l'enregistrement du paiement.</h2>";
    }
} else {
    echo "<h2>Accès non autorisé.</h2>";
}
?>
