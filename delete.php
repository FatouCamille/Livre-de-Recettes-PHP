<?php
session_start();
require 'db.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifie que l'ID est présent
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de la recette manquant.";
    exit();
}

$id = $_GET['id'];

// Supprime la recette de la base
$stmt = $pdo->prepare("DELETE FROM recette WHERE id = ?");
$stmt->execute([$id]);

// Redirige vers le tableau de bord après suppression
header("Location: dashboard.php");
exit();
