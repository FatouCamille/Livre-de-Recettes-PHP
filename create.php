<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une recette</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff0f5;
            padding: 20px;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.3);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            margin-top: 20px;
            background-color: #ff69b4;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background-color: #ff1493;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #ff1493;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Ajouter une nouvelle recette</h1>

    <form action="store.php" method="post" enctype="multipart/form-data">

        <label for="nom">Nom de la recette :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="type">Type (plat, dessert, etc.) :</label>
        <input type="text" name="type" id="type" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>

        <label for="ingredients">Ingrédients :</label>
        <textarea name="ingredients" id="ingredients" required></textarea>

        <label for="image">Image de la recette :</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Enregistrer</button>
    </form>

    <a href="dashboard.php">⬅ Retour au tableau de bord</a>

</body>
</html>
