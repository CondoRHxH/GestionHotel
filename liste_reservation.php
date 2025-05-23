<?php 
include 'db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Réservations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      background-color: #f8f9fa;
      padding: 30px;
    }
    .navbar {
      background-color: #00032e;
    }
    .navbar .navbar-brand {
      color: wheat;
    }
    .container {
      max-width: 800px;
      margin: auto;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      margin-bottom: 30px;
    }
    .card-title {
      font-weight: bold;
    }
    .btn-danger {
      margin-top: 10px;
    }
    .navbar {
  background-color: #00032e;
  height: 110px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.logo {
  height: 110px;
  width: 200px;
  object-fit: contain;
}

.navbar .navbar-brand,
.navbar .nav-link {
  color: wheat !important;
  font-weight: 600;
  font-size: 17px;
  transition: color 0.3s ease;
}

.navbar .nav-link:hover,
.navbar .navbar-brand:hover {
  color: #ffffff !important;
}

.navbar-toggler {
  border: 1px solid wheat;
}

.navbar-toggler-icon {
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='wheat' viewBox='0 0 30 30'%3e%3cpath stroke='wheat' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22' /%3e%3c/svg%3e");
}

  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="page_acceuil.html"><img class="logo" src="images/WhatsApp Image 2025-05-15 at 16.37.30.jpeg" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
       <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          
         <li class="nav-item">
            <a class="navbar-brand" href="reservation.php">Reserver</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand" href="liste_reservation.php">Mes réservations</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand" href="apropos.html">A Propos Nous</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<div class="mt-5">
  <h1 style="color: #f8f9fa;">each</h1>
</div>
<div class="container mt-5">
  <h1 class="mb-4 text-primary text_center "style="color: black !important;">Vos réservations</h1>

  <!-- Formulaire de recherche -->
  <form method="post" class="mb-4">
    <div class="input-group">
      <input type="text" name="nom" class="form-control" placeholder="Entrez votre nom complet" required value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
     <button type="submit" class="btn" style="background-color: wheat; color: black;">Rechercher</button>

    </div>
  </form>

<?php
// Traitement de la suppression d'une réservation spécifique
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["suppression"])) {
    $id_reservation = $_POST["id_reservation"];
    try {
        $stmt = $pdo->prepare("DELETE FROM reservation WHERE id_reservation = ?");
        $stmt->execute([$id_reservation]);
        echo '<div class="alert alert-success">La réservation a été supprimée avec succès.</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Erreur lors de la suppression : ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    // Repeupler le champ de recherche pour réafficher les réservations restantes
    $_POST['nom'] = $_POST['nom'] ?? '';
}

// Traitement de la recherche des réservations
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["nom"])) {
    $nom = '%' . $_POST["nom"] . '%';
    $nomComplet = $_POST["nom"]; // Pour affichage dans la recherche

    try {
        $stmt = $pdo->prepare("
            SELECT client.nomComplet, client.email, reservation.date_debut, reservation.date_fin, 
                   DATEDIFF(reservation.date_fin, reservation.date_debut) AS nuits, 
                   chambre.prix, 
                   DATEDIFF(reservation.date_fin, reservation.date_debut) * chambre.prix AS total,
                   reservation.id_reservation
            FROM reservation
            INNER JOIN client ON reservation.id_client = client.id_client
            INNER JOIN chambre ON reservation.id_chambre = chambre.id_chambre
            WHERE client.nomComplet LIKE :nom
            ORDER BY reservation.date_debut ASC
        ");

        $stmt->execute(['nom' => $nom]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($reservations && count($reservations) > 0):
            foreach ($reservations as $res): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($res['nomComplet']) ?></h5>
                        <p class="card-text">
                            <strong>Email :</strong> <?= htmlspecialchars($res['email']) ?><br>
                            <strong>Séjour :</strong> du <?= htmlspecialchars($res['date_debut']) ?> au <?= htmlspecialchars($res['date_fin']) ?><br>
                            <strong>Nombre de nuits :</strong> <?= htmlspecialchars($res['nuits']) ?><br>
                            <strong>Prix par nuit :</strong> <?= htmlspecialchars($res['prix']) ?> MAD<br>
                            <strong>Total à payer :</strong> <span class="text-success"><?= number_format($res['total'], 2) ?> MAD</span>
                        </p>
                        <form method="post">
                            <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($res['id_reservation']) ?>">
                            <input type="hidden" name="nom" value="<?= htmlspecialchars($nomComplet) ?>">
                            <button type="submit" name="suppression" value="1" class="btn btn-danger btn-center" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                Annuler cette réservation
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach;
        else:
            echo '<div class="alert alert-warning">⚠️ Il n\'y a aucune réservation sous le nom : <strong>' . htmlspecialchars($_POST['nom']) . '</strong>.</div>';
        endif;

    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Erreur : ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
</div>
</body>
</html>