<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID de la recette manquant.";
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM recette WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit();
