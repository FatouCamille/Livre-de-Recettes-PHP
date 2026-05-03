<?php
require 'db.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $type = $_POST['type'] ?? '';
    $description = $_POST['description'] ?? '';
    $ingredients = $_POST['ingredients'] ?? '';
    $image_path = null;

    if (!empty($_FILES['image']['name'])) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); 
        }

        $filename = uniqid() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $image_path = $targetPath;
        }
    }

    $stmt = $pdo->prepare("INSERT INTO recette (nom, type, description, ingredients, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $type, $description, $ingredients, $image_path]);

    header('Location: dashboard.php');
    exit();
}
