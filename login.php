<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Connexion à l'espace d'administration</h2>

    <form action="authenticate.php" method="POST">
        <label for="username">Nom d'utilisateur :</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Mot de passe :</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
