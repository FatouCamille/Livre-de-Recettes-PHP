<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue - Livre de Recettes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>🍰 Bienvenue dans le Livre de Recettes,votre bibliothèque culinaire intéractive:créez,exolorez et savourez vos plats préférés en quelques clics! !</h1>
    
    <?php if (isset($_SESSION['admin_id'])): ?>
        <p>Vous êtes connecté !</p>
        <a href="dashboard.php"><button>Accéder au tableau de bord</button></a>
    <?php else: ?>
        <p>Connectez-vous pour gérer vos recettes.</p>
        <a href="login.php"><button>Se connecter</button></a>
    <?php endif; ?>
</body>
</html>

