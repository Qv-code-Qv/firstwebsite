<?php
// 1. Fonction pour charger les variables du fichier .env
function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Ignore les commentaires
        list($name, $value) = explode('=', $line, 2);
        $_ENV[trim($name)] = trim($value);
    }
}

// 2. Chargement des identifiants
loadEnv(__DIR__ . '/.env');

$host   = $_ENV['DB_HOST'];
$port   = $_ENV['DB_PORT'];
$user   = $_ENV['DB_USER'];
$pass   = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

// 3. Tentative de connexion
try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h1>Succès !</h1>";
    echo "Connexion réussie";
} catch(PDOException $e) {
    echo "<h1>Échec de connexion</h1>";
    echo "Erreur : " . $e->getMessage();
}
?>