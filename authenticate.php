<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Requête préparée pour éviter les injections SQL
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        // Connexion réussie
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        header("Location: dashboard.php"); // Redirige vers la page d'administration
        exit();
    } else {
        // Échec d'authentification
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
