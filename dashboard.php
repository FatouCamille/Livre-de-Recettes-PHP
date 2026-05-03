<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';

$stmt = $pdo->query("SELECT * FROM recette ORDER BY id DESC");
$recettes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Livre de Recettes Glamour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background: #fff5f8; color: #5d0c35; padding: 20px; }
        
        /* TITRE DEMANDÉ */
        h1 { text-align: center; color: #d81b60; margin-bottom: 20px; font-size: 2.5em; }
        h1 i { color: #ec407a; margin-right: 10px; }

        .search-container { text-align: center; margin-bottom: 30px; }
        #searchBar {
            padding: 12px 20px; width: 300px; border-radius: 50px;
            border: 2px solid #f8bbd0; outline: none; transition: 0.3s;
        }
        #searchBar:focus { border-color: #ec407a; box-shadow: 0 0 10px rgba(236, 64, 122, 0.2); }

        .nav-links { text-align: center; margin-bottom: 30px; }
        .btn-add { background: #ec407a; color: white; padding: 10px 25px; text-decoration: none; border-radius: 50px; font-weight: bold; box-shadow: 0 4px 10px rgba(236,64,122,0.2); transition: 0.3s; }
        .btn-add:hover { background: #ad1457; transform: scale(1.05); }

        /* GRILLE 4 COLONNES */
        .container-recettes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); 
            gap: 25px; max-width: 1200px; margin: 0 auto;
        }

        .recipe-card {
            background: white; border-radius: 25px; overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05); transition: 0.3s;
            border: 1px solid #fce4ec; display: flex; flex-direction: column;
        }
        .recipe-card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(216, 27, 96, 0.1); }

        .recipe-card img { width: 100%; height: 180px; object-fit: cover; }
        .card-body { padding: 20px; flex-grow: 1; }
        
        .recipe-title { 
            margin: 0; font-size: 1.2em; color: #ad1457; cursor: pointer; 
            display: flex; align-items: center; justify-content: space-between;
            transition: 0.2s;
        }
        .recipe-title:hover { color: #ec407a; }

        .type-badge { font-size: 0.75em; color: #d81b60; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; display: block; }

        .details-content { 
            display: none; font-size: 0.9em; color: #666; 
            margin-top: 15px; border-top: 1px dashed #f8bbd0; padding-top: 15px;
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .card-footer { padding: 15px 20px; background: #fffcfd; display: flex; justify-content: space-between; border-top: 1px solid #fce4ec; }
        .action-btn { text-decoration: none; font-size: 0.85em; font-weight: bold; transition: 0.2s; }
        .edit { color: #ec407a; } .edit:hover { color: #ad1457; }
        .delete { color: #ff5252; } .delete:hover { color: #b71c1c; }
    </style>
</head>
<body>

    <h1><i class="fa-solid fa-utensils"></i> Mon Livre de Recettes</h1>

    <div class="search-container">
        <input type="text" id="searchBar" onkeyup="filterRecipes()" placeholder="Chercher une recette...">
    </div>

    <div class="nav-links">
        <a href="create.php" class="btn-add"><i class="fa-solid fa-plus"></i> Ajouter une recette</a>
        <a href="logout.php" style="color: #999; margin-left: 20px; text-decoration: none; font-size: 0.9em;">Déconnexion</a>
    </div>

    <div class="container-recettes" id="recipeGrid">
        <?php foreach ($recettes as $recette): ?>
            <div class="recipe-card">
                <?php if (!empty($recette['image_path'])): ?>
                    <img src="<?= htmlspecialchars($recette['image_path']) ?>" alt="Image">
                <?php else: ?>
                    <img src="https://via.placeholder.com/300x180?text=Ma+Douceur" alt="Pas d'image">
                <?php endif; ?>

                <div class="card-body">
                    <span class="type-badge"><?= htmlspecialchars($recette['type']) ?></span>
                    
                    <h2 class="recipe-title" onclick="toggleDetails(this)">
                        <?= htmlspecialchars($recette['nom']) ?>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.7em; opacity: 0.5;"></i>
                    </h2>
                    
                    <div class="details-content">
                        <p><strong><i class="fa-solid fa-align-left"></i> Description :</strong><br>
                        <?= nl2br(htmlspecialchars($recette['description'])) ?></p>
                        
                        <p><strong><i class="fa-solid fa-list-ul"></i> Ingrédients :</strong><br>
                        <?= nl2br(htmlspecialchars($recette['ingredients'])) ?></p>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="edit.php?id=<?= $recette['id'] ?>" class="action-btn edit"><i class="fa-solid fa-pen"></i> Modifier</a>
                    <a href="delete.php?id=<?= $recette['id'] ?>" class="action-btn delete" onclick="return confirm('Supprimer cette recette ?')"><i class="fa-solid fa-trash"></i> Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Recherche instantanée
        function filterRecipes() {
            let input = document.getElementById('searchBar').value.toLowerCase();
            let cards = document.getElementsByClassName('recipe-card');
            for (let i = 0; i < cards.length; i++) {
                let title = cards[i].querySelector('.recipe-title').innerText.toLowerCase();
                cards[i].style.display = title.includes(input) ? "" : "none";
            }
        }

        // Afficher/Cacher les détails
        function toggleDetails(titleElement) {
            let detailDiv = titleElement.nextElementSibling;
            let icon = titleElement.querySelector('i');
            if (detailDiv.style.display === "block") {
                detailDiv.style.display = "none";
                icon.style.transform = "rotate(0deg)";
            } else {
                detailDiv.style.display = "block";
                icon.style.transform = "rotate(180deg)";
            }
        }
    </script>
</body>
</html>