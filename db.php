<?php
$host = "127.0.0.1:3308"; 
$user = "root";
$password = "";
$db = "projethotel";

$conn = new mysqli($host, $user, $password, $db);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion réussie à la base $db (PDO) !";
} catch (PDOException $e) {
    die("❌ Échec de la connexion : " . $e->getMessage());
}
?>