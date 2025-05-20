<?php
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Réservations</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-4">Réservations enregistrées</h1>

    <?php
    $stmt = $pdo->query("SELECT * FROM reservation ORDER BY date_enregistrement DESC");
    $reservation = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($reservation):
      foreach ($reservation as $res): ?>
        <div class="card mb-3">
          <div class="card-body">
            <h5><?= htmlspecialchars($res['nom']) ?> (<?= htmlspecialchars($res['email']) ?>)</h5>
            <p><strong>Chambre :</strong> <?= htmlspecialchars($res['chambre']) ?> | <strong>Activité :</strong> <?= htmlspecialchars($res['activite']) ?></p>
            <p><strong>Du :</strong> <?= $res['checkin'] ?> au <?= $res['checkout'] ?> (<?= $res['nuits'] ?> nuit(s))</p>
            <p><strong>Total :</strong> <?= number_format($res['total'], 2) ?> MAD</p>
            <p class="text-muted"><small>Réservé le <?= $res['date_enregistrement'] ?></small></p>
          </div>
        </div>
    <?php
      endforeach;
    else:
      echo "<p>Aucune réservation trouvée.</p>";
    endif;
    ?>
  </div>
</body>
</html>
