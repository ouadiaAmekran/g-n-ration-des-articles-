<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form action="signup_handler.php" method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>
        
        <label for="role">Rôle :</label>
        <select id="role" name="role">
            <option value="Editeur">Éditeur</option>
            <option value="Admin">Admin</option>
        </select><br><br>
        
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
