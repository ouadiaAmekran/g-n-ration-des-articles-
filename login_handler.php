<?php
session_start();

// Connexion à la base de données
$host = 'localhost'; // Remplacez par vos paramètres de connexion
$dbname = 'articl';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupération des données du formulaire
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Vérification des informations d'identification
$sql = "SELECT * FROM utilisateurs WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
    // Authentification réussie
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_nom'] = $user['nom'];
    $_SESSION['user_role'] = $user['role'];
    
    // Redirection en fonction du rôle
    if ($user['role'] == 'Admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: editeur_dashboard.php");
    }
    exit;
} else {
    echo "Email ou mot de passe incorrect.";
}
?>
