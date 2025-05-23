<?php  include('db.php') ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nos Chambres - Hôtel LUXE</title>
  <link rel="stylesheet" href="style">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f6f9;
      color: #333;
    }
    .navbar {
      background-color: #00032e;
    }
    .navbar .navbar-brand, .navbar .nav-link {
      color: wheat;
      font-weight: 500;
    }
    .navbar .nav-link:hover {
      color: wheat;
    }

    .header {
      background: linear-gradient(to right, #00032e, #00032e);
      color: wheat;
      padding: 60px 0;
      text-align: center;
    }

    .header h1 {
      font-size: 3rem;
      font-weight: bold;
    }

    .room-section {
      padding: 60px 0;
    }

    .room-card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      margin-bottom: 40px;
      transition: transform 0.3s;
    }

    .room-card:hover {
      transform: translateY(-5px);
    }

    .room-card img {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    .room-content {
      padding: 30px;
    }

    .room-content h3 {
      font-weight: 600;
      margin-bottom: 15px;
    }

    .room-content ul {
      padding-left: 20px;
    }

    .btn-reserver {
      background-color: #0d6efd;
      color: white;
      padding: 10px 24px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      transition: background-color 0.3s ease;
      margin-top: 15px;
    }

    .btn-reserver:hover {
      background-color: #0a58ca;
    }

     .footer {
  background-color: #00032e;
  color: wheat;
  padding: 40px 20px 20px;
  font-family: Arial, sans-serif;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 30px;
  max-width: 1200px;
  margin: auto;
}

.footer-section {
  flex: 1 1 220px;
  min-width: 250px;
}

.footer-section h3 {
  margin-bottom: 15px;
  font-size: 18px;
  border-bottom: 2px solid wheat;
  display: inline-block;
  padding-bottom: 5px;
}

.footer-section p,
.footer-section li {
  font-size: 14px;
  line-height: 1.6;
  color: wheat;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section ul li a {
  color: wheat;
  text-decoration: none;
  transition: color 0.3s;
}

.footer-section ul li a:hover {
  color: #ffffff;
}

.social-icons a {
  color: wheat;
  font-size: 18px;
  margin-right: 15px;
  transition: transform 0.3s, color 0.3s;
}

.social-icons a:hover {
  transform: scale(1.3);
  color: #fff;
}

.footer-section .newsletter form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.footer-section .newsletter input[type="email"] {
  padding: 8px;
  border: none;
  border-radius: 4px;
}

.footer-section .newsletter button {
  background-color: wheat;
  color: #00032e;
  border: none;
  padding: 8px;
  border-radius: 4px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s;
}

.footer-section .newsletter button:hover {
  background-color: #fff;
  color: #000;
}

.footer-bottom {
  text-align: center;
  padding-top: 20px;
  border-top: 1px solid #ffffff33;
  font-size: 13px;
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


    .btn[disabled] {
  background-color: #ccc;
  color: #444;
  border: none;
}
#button {
  display: inline-block;
  position: relative;
  padding: 14px 30px;
  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
  color: #00032e;
  background: wheat;
  border: none;
  border-radius: 50px;
  text-decoration: none;
  overflow: hidden;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  transition: all 0.4s ease;
  cursor: pointer;
}

#button span {
  position: relative;
  z-index: 2;
}

#button::before {
  content: "";
  position: absolute;
  top: 0;
  left: -75%;
  width: 50%;
  height: 100%;
  background: rgba(0, 3, 46, 0.2); /* لمعان بلون غامق */
  transform: skewX(-25deg);
  transition: left 0.6s ease;
  z-index: 1;
}

#button:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
}

#button:hover::before {
  left: 125%;
}
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="page_acceuil.html"><img class="logo" src="images/WhatsApp Image 2025-05-15 at 16.37.30.jpeg" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
       <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="navbar-brand" href="page_acceuil.html">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand" href="reservation.php">Réserver</a>
          </li>
          <li class="nav-item">
            <a class="navbar-brand" href="liste_reservation.php">Mes réservations</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <div class="header mt-5">
    <div class="container">
      <h1>Nos Chambres</h1>
      <p>Choisissez le confort qui vous convient à Hôtel LUXE</p>
    </div>
  </div>

<!-- Chambres -->
<section class="room-section container">
  <!-- Suite Royale -->
  <div class="room-card">
    <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c" alt="Suite Royale">
    <div class="room-content">
      <h3>Suite Royale</h3>
      <!-- <p><strong>Prix :</strong> 3500 MAD / nuit</p> -->
      <p>Un espace somptueux avec salon privé, balcon et jacuzzi pour une expérience royale.</p>
      <ul>
        <li>Lit King-size</li>
        <li>Jacuzzi & balcon</li>
        <li>Salon privé</li>
        <li>Vue panoramique</li>
        <?php

$sql = "SELECT COUNT(*) AS dispo FROM chambre WHERE disponibilite = 1 And type='Royal'";
$result = $conn->query($sql);

$nombre = 0;
$rupture = false;

if ($result && $row = $result->fetch_assoc()) {
    $nombre = $row['dispo'];

    if ($nombre > 0) {
        echo "<p>Nombre de chambres disponibles : <strong>$nombre</strong></p>";
    } else {
        echo "<p style='color:red;'>Aucune chambre disponible !</p>";
        $rupture = true;
    }
} else {
    echo "<p>❌ Erreur lors du chargement des données.</p>";
    $rupture = true;
}

?>
      </ul>
      <?php if (!$rupture): ?>
    <a href="reservation.php" type="submit" class="btn" id="button" style="background-color: wheat; color: black;">Reserver</a>
    
<?php else: ?>
    <button class="btn btn-secondary" id="button" disabled style="opacity: 0.6; cursor: not-allowed;">
        Rupture de stock
    </button>
<?php endif; ?>
      <!-- <a href="reservation.php" class="btn btn-primary" id="button"><span>Réserver</span></a> -->
    </div>
  </div>

  <!-- Chambre Double -->
  <div class="room-card">
    <img src="images/suite-de-chambre-de-luxe-de-rendu-3d-dans-un-hotel-de-villegiature-avec-lit-jumeau-et-salon.jpg" alt="Chambre Double">
    <div class="room-content">
      <h3>Chambre Double</h3>
      <!-- <p><strong>Prix :</strong> 1800 MAD / nuit</p> -->
      <p>Parfaite pour les couples ou les amis, avec deux lits confortables et toutes commodités.</p>
      <ul>
        <li>Deux lits simples</li>
        <li>Salle de bain moderne</li>
        <li>Wi-Fi gratuit</li>
        <li>Petit-déjeuner inclus</li>
      
        <?php
        
$sql = "SELECT COUNT(*) AS dispo FROM chambre WHERE disponibilite = 1 And type='double'";
$result = $conn->query($sql);

$nombre = 0; // valeur par défaut
$rupture = false;

if ($result && $row = $result->fetch_assoc()) {
    $nombre = $row['dispo'];

    if ($nombre > 0) {
        echo "<p>Nombre de chambres disponibles : <strong>$nombre</strong></p>";
    } else {
        echo "<p style='color:red;'>Aucune chambre disponible !</p>";
        $rupture = true;
    }
} else {
    echo "<p>❌ Erreur lors du chargement des données.</p>";
    $rupture = true;
}

?>
      </ul>
      <?php if (!$rupture): ?>
        <a href="reservation.php" type="submit" class="btn" id="button" style="background-color: wheat; color: black;">Reserver</a>

<?php else: ?>
    <button class="btn btn-secondary" id="button" disabled style="opacity: 0.6; cursor: not-allowed;">
        Rupture de stock
    </button>
<?php endif; ?>
        
        
      </ul>
      <!-- <a href="reservation.php" class="btn btn-primary" id="button"><span>Réserver</span></a> -->
    </div>
  </div>

  <!-- Chambre Simple -->
  <div class="room-card">
    <img src="images/petit-interieur-de-chambre-d-hotel-avec-lit-double-et-salle-de-bain.jpg" alt="Chambre Simple">
    <div class="room-content">
      <h3>Chambre Simple</h3>
      <!-- <p><strong>Prix :</strong> 950 MAD / nuit</p> -->
      <p>Idéale pour les voyageurs solo souhaitant le confort et la tranquillité à prix doux.</p>
      <ul>
        <li>Lit simple confortable</li>
        <li>Bureau de travail</li>
        <li>Douche privative</li>
        <li>Wi-Fi & TV écran plat</li>
        
          <?php
        
$sql = "SELECT COUNT(*) AS dispo FROM chambre WHERE disponibilite = 1 And type='simple'";
$result = $conn->query($sql);

$nombre = 0; // valeur par défaut
$rupture = false;

if ($result && $row = $result->fetch_assoc()) {
    $nombre = $row['dispo'];

    if ($nombre > 0) {
        echo "<p>Nombre de chambres disponibles : <strong>$nombre</strong></p>";
    } else {
        echo "<p style='color:red;'>Aucune chambre disponible !</p>";
        $rupture = true;
    }
} else {
    echo "<p>❌ Erreur lors du chargement des données.</p>";
    $rupture = true;
}

?>
      </ul>
      <?php if (!$rupture): ?>
    <a href="reservation.php" type="submit" class="btn" id="button" style="background-color: wheat; color: black;">Reserver</a>

        <?php else: ?>
    <button class="btn btn-secondary" id="button" disabled style="opacity: 0.6; cursor: not-allowed;">
        Rupture de stock
    </button>
<?php endif; ?>
        </li>
      </ul>
      
    </div>
  </div>
</section>


  <!-- Footer -->
  
<footer class="footer">
  <div class="footer-container">
    <div class="footer-section about">
      
      <p>Nous offrons l'un des meilleurs chambres.</p>
      <div class="social-icons">
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>

    <div class="footer-section links">
      <h3>Quick Links</h3>
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="services.html">Services</a></li>
        <!-- <li><a href="chambre.php">Chambres</a></li> -->


      </ul>
    </div>

    <div class="footer-section contact">
      <h3>Contact Us</h3>
      <p><i class="fas fa-map-marker-alt"></i>Quartier Atlas 2, Ifrane, Morocco</p>
      <p><i class="fas fa-phone"></i> +212 5 99 15 44 44</p>
      <p><i class="fas fa-envelope"></i> CoinTranquille@gmail.com</p>
    </div>

    <div class="footer-section newsletter">
      <h3>Newsletter</h3>
      <p>Rester en contact avec nous.</p>
      <form>
        <input type="email form-control" placeholder="Your email" required>
        <button type="submit" class="btn btn-primary mt-2">Subscribe</button>
      </form>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 All rights reserved.</p>
  </div>
</footer>


</body>
</html>
