<?php
include 'db.php';
$recapVisible = false; // Drapeau pour afficher le récapitulatif uniquement après POST
$types = ["Simple", "Double", "Suite"];
// $dispoChambres = [];

// foreach ($types as $type) {
//     $sql = "SELECT COUNT(*) AS dispo FROM chambre WHERE type ='Simple' AND disponibilite= 1";
//     $result = $conn->query($sql);
//     $row = $result->fetch_assoc();
//     $dispoChambres[$type] = $row['dispo']  ;
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $recapVisible = true;

  $nomComplet = $_POST['nomComplet'] ?? '';
  $date_debut = $_POST['date_debut'] ?? '';
  $date_fin = $_POST['date_fin'] ?? '';
  $email = $_POST['email'] ?? '';
  $room = $_POST['room'] ?? '';
  $activity = isset($_POST['activity']) && $_POST['activity'] !== '' ? $_POST['activity'] : 'aucune activité';
  $promo = $_POST['promo_code'] ?? '';

$subtotal = 0;
$discount = 0;  // calcule montant
$total = 0;


  // Get room data including price  selectionner prix
$stmtRoom = $pdo->prepare("SELECT id_chambre, prix FROM chambre WHERE type = ? AND disponibilite = 1 LIMIT 1");
$stmtRoom->execute([$room]);
$roomData = $stmtRoom->fetch();

if ($roomData) {
    $id_chambre = $roomData['id_chambre'];
    $pricePerNight = $roomData['prix'];  // ✅ prix depuis la BD
}

// Charger les activités depuis la base  njiboo les services mn bddd
$activities = [];
$stmtActivities = $pdo->query("SELECT id_activite, libelle, prix FROM activite");
while ($row = $stmtActivities->fetch()) {
    $activities[$row['libelle']] = [
        'id' => $row['id_activite'],
        'prix' => $row['prix']
    ];
}


 $date_debut_obj = new DateTime($date_debut);
$date_fin_obj = new DateTime($date_fin);

$date_debut_str = $date_debut_obj->format('Y-m-d');
$date_fin_str = $date_fin_obj->format('Y-m-d');

// correction erreur f diff (kaydir 0 jours daba)
$nights = $date_debut_obj->diff($date_fin_obj)->days;


  $subtotal = $pricePerNight * $nights;   // montantntntnt 
  $total = $subtotal;  // prix chambre seulement


  // Tarifs des activités
  $activityPrices = [
    "Spa" => 150,
    "Piscine" => 50,
    "Salle de sport" => 30,
    "Excursion" => 200,
  ];
  $activityCost = $activityPrices[$activity] ?? 0;
  $total += $activityCost;  // Ajouter le coût de l'activité au total

// $sql = "SELECT COUNT(*) AS dispo FROM users WHERE name = '$room' AND last_name = 1";
// $result = $conn->query($sql);
// $row = $result->fetch_assoc();

// if ($row['dispo'] > 0) {
//     echo "<p style='color:red;'>❌ Rupture de stock pour la chambre $room</p>";
//     $recapVisible = false; // Ne pas afficher le récapitulatif
// } else {

// Inserere client
$stmtClient = $pdo->prepare("INSERT INTO client (nomComplet, email) VALUES (?, ?)");
$stmtClient->execute([$nomComplet, $email]);
    $id_client = $pdo->lastInsertId();
    




// Insert Réservation
$stmtRoom = $pdo->prepare("SELECT id_chambre FROM chambre WHERE type = ? AND disponibilite = 1");
$stmtRoom->execute([$room]); // ✅ daba logique
$roomData = $stmtRoom->fetch();

 // ici room ja mn $_POST



if ($roomData) {
    $id_chambre = $roomData['id_chambre'];

    // Marquer chambre comme réservée
    $updateDispo = $pdo->prepare("UPDATE chambre SET disponibilite = 0 WHERE id_chambre = ?");
    $updateDispo->execute([$id_chambre]);

    // Insérer réservation complète
$stmtReservation = $pdo->prepare("INSERT INTO reservation (date_debut, date_fin, id_chambre, id_client) VALUES (?, ?, ?, ?)");
$stmtReservation->execute([$date_debut_str, $date_fin_str, $id_chambre, $id_client]); // ✅
if ($stmtClient && $stmtReservation) {
    echo "✅ Client et réservation insérés avec succès.";
}


} else {
    echo "<p style='color:red;'>❌ Aucun chambre $room disponible.</p>";
    $recapVisible = false;
}


}
$roomsDispo = [];
$stmt = $pdo->query("SELECT type, COUNT(*) as dispo FROM chambre WHERE disponibilite = 1 GROUP BY type");
while ($row = $stmt->fetch()) {
    $roomsDispo[$row['type']] = $row['dispo'];
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Checkout Réservation</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      background-color: #f8f9fa;
      padding: 30px;
    }
    li{
      color: wheat;
    }
    .navbar {
      background-color: #00032e;
    }
    .navbar .navbar-brand, .navbar .nav-link {
      color: wheat;
      font-weight: 500;
    }
    .navbar .nav-link:hover {
      color:wheat;
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
    .card h2 {
      background-color: #00032e;
      color: wheat;
      padding: 15px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
    .card-body input, .card-body select {
      margin-bottom: 15px;
    }
    .summary .details {
      display: grid;
      grid-template-columns: 1fr 1fr;
      row-gap: 10px;
    }
    .footer {
      text-align: center;
    }
    .footer .price {
      font-size: 1.5rem;
      font-weight: bold;
      color: #00032e;
      margin-bottom: 10px;
    }
    .btn-primary {
      background-color: #00032e;
      border: none;
      color: wheat;
    }
    .btn-primary:hover {
      background-color: #00032e;
    }
    .navbar {
      background-color: #00032e;
      height: 110px;
    }
    .navbar .navbar-brand, .navbar .nav-link {
      color: 	wheat;
      font-weight: 500;
    }
    .navbar .nav-link:hover {
      color: wheat;
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
   <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="page_acceuil.html"><img class="logo" src="images/WhatsApp Image 2025-05-15 at 16.37.30.jpeg" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
       <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="navbar-brand" href="apropos.html">A Propos Nous</a>
          </li>
         
          <li class="nav-item">
            <a class="navbar-brand" href="liste_reservation.php">Mes réservations</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
<?php
// Charger les activités depuis la base
$activities = [];
$stmtActivities = $pdo->query("SELECT id_activite, libelle, prix FROM activite");
while ($row = $stmtActivities->fetch()) {
    $activities[$row['libelle']] = [
        'id' => $row['id_activite'],
        'prix' => $row['prix']
    ];
}
?>
<div class="mt-5">
  <h1 style="color: #f8f9fa;">each</h1>
</div>
<div class="container mt-5">
  <form method="POST" class="card">
    <h2 class="text-center">Réservation de chambre</h2>
    <div class="card-body">
      <input type="text" name="nomComplet" class="form-control" placeholder="Nom" required>
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="date" id="checkin" name="date_debut" class="form-control" required>
      <input type="date" id="checkout" name="date_fin" class="form-control" required>
      <select name="room" class="form-select" required>
  <option value="">-- Choisir une chambre --</option>
  <?php
  $types = ['Simple', 'Double', 'Royal'];
  foreach ($types as $type) {
      $dispo = $roomsDispo[$type] ?? 0;
      $disabled = $dispo == 0 ? 'disabled style="color:gray;"' : '';
      echo "<option value=\"$type\" $disabled>$type" . ($dispo == 0 ? " (Indisponible)" : "") . "</option>";
  }
  ?>
</select>

       <select name="activity" class="form-control">  <!-- kanjibooo ls info ln bd -->
  <option value="">-- Choisir une activité --</option>
  <?php foreach ($activities as $libelle => $data): ?>
    <option value="<?= htmlspecialchars($libelle) ?>">
      <?= htmlspecialchars($libelle) ?> (<?= number_format($data['prix'], 2) ?> MAD)
    </option>
  <?php endforeach; ?>
</select>

     
      <button type="submit" class="btn btn-primary w-100">Réserver</button>
    </div>
  </form>

  <?php if ($recapVisible): ?>
    <div class="card summary">
      <h2 class="text-center">Récapitulatif</h2>
      <div class="card-body">
        <p><strong>Nom :</strong> <?= htmlspecialchars($nomComplet) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
        <hr>
        <p><strong>Chambre :</strong> <?= htmlspecialchars($room) ?> (<?= $nights ?> nuit(s))</p>
        <p><strong>Du :</strong> <?= (new DateTime($date_debut))->format('d/m/Y') ?> au <?= (new DateTime($date_fin))->format('d/m/Y') ?></p>
        <hr>
        <p><strong>Activité :</strong> <?= htmlspecialchars($activity) ?> 
          <?php if ($activity !== 'aucune activité'): ?>
            (<?= number_format($activityCost, 2) ?> MAD)
          <?php endif; ?>
        </p>
        <hr>
        <div class="details">
          <span>Chambre :</span><span><?= number_format($subtotal, 2) ?> MAD</span>
<?php if ($activity !== 'aucune activité'): ?>
  <span>Activité :</span><span><?= number_format($activityCost, 2) ?> MAD</span>
<?php endif; ?>
  <!--Nouveau prix-->
          <?php if ($discount > 0): ?>
            <span>Remise promo :</span><span>-<?= number_format($discount, 2) ?> MAD</span>
          <?php endif; ?>
        </div>
        <div class="footer mt-3">
          <div class="price">Total : <?= number_format($total, 2) ?> MAD</div>
          <a href="paiement.html" class="btn btn-primary w-100" id="button"><span>Procéder au paiement</span></a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  window.addEventListener("DOMContentLoaded", () => {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const minDate = `${year}-${month}-${day}`;
    document.getElementById("checkin").setAttribute("min", minDate);
    document.getElementById("checkout").setAttribute("min", minDate);
  });

  <!-- <?php foreach ($types as $type): ?>
        <?php if ($dispoChambres[$type] > 0): ?>
            <option value="<?= $type ?>"><?= $type ?></option>
        <?php else: ?>
            <option value="<?= $type ?>" disabled><?= $type ?> (Indisponible)</option>
        <?php endif; ?>
    <?php endforeach; ?> -->
</script>
</body>
</html>
