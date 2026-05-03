<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM recette WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $recette = $stmt->fetch();
}

if (!$recette) {
    die("Recette non trouvée.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la recette - Glamour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff5f8;
            color: #5d0c35;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        h1 {
            color: #d81b60;
            font-size: 2em;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(216, 27, 96, 0.1);
            width: 100%;
            max-width: 500px;
            border: 1px solid #fce4ec;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #ad1457;
            margin-bottom: 8px;
            font-size: 0.9em;
        }

        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #fce4ec;
            border-radius: 12px;
            background: #fffcfd;
            font-family: inherit;
            box-sizing: border-box; 
            outline: none;
            transition: 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #f48fb1;
            background: white;
        }

        textarea {
            height: 120px;
            resize: vertical;
        }

        .btn-save {
            width: 100%;
            background: linear-gradient(45deg, #ec407a, #f48fb1);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(236, 64, 122, 0.3);
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-save:hover {
            transform: scale(1.02);
            background: linear-gradient(45deg, #ad1457, #ec407a);
        }

        .back-link {
            margin-top: 25px;
            text-decoration: none;
            color: #ec407a;
            font-weight: 600;
            font-size: 0.9em;
        }

        .back-link:hover {
            color: #880e4f;
        }
    </style>
</head>
<body>

    <h1><i class="fa-solid fa-pen-fancy"></i> Modifier la recette</h1>

    <div class="form-container">
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $recette['id'] ?>">

            <div class="form-group">
                <label>Nom de la douceur :</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($recette['nom']) ?>" required>
            </div>

            <div class="form-group">
                <label>Type de plat :</label>
                <select name="type">
                    <option value="Entrée" <?= $recette['type'] == 'Entrée' ? 'selected' : '' ?>>Entrée</option>
                    <option value="Plat" <?= $recette['type'] == 'Plat' ? 'selected' : '' ?>>Plat</option>
                    <option value="Dessert" <?= $recette['type'] == 'Dessert' ? 'selected' : '' ?>>Dessert</option>
                </select>
            </div>

            <div class="form-group">
                <label>Description :</label>
                <textarea name="description"><?= htmlspecialchars($recette['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Ingrédients secrets :</label>
                <textarea name="ingredients"><?= htmlspecialchars($recette['ingredients']) ?></textarea>
            </div>

            <button type="submit" class="btn-save">
                <i class="fa-solid fa-heart"></i> Enregistrer les modifications
            </button>
        </form>
    </div>

    <a href="dashboard.php" class="back-link"><i class="fa-solid fa-arrow-left"></i> Retour au tableau de bord</a>

</body>
</html>
