<?php
session_start();
require 'db.php';


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}


if (
    !isset($_POST['id']) ||
    !isset($_POST['nom']) ||
    !isset($_POST['type']) ||
    !isset($_POST['description']) ||
    !isset($_POST['ingredients'])
) {
    echo "Données manquantes.";
    exit();
}

$id = $_POST['id'];
$nom = $_POST['nom'];
$type = $_POST['type'];
$description = $_POST['description'];
$ingredients = $_POST['ingredients'];


$stmt = $pdo->prepare("UPDATE recette SET nom = ?, type = ?, description = ?, ingredients = ? WHERE id = ?");
$stmt->execute([$nom, $type, $description, $ingredients, $id]);


header("Location: dashboard.php");
exit();
