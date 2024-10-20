<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <form action="login_handler.php" method="POST">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required><br><br>
        
        <button type="submit">Se connecter</button>
    </form>
    
    <p>Pas encore inscrit ? <a href="signup.php"><button>S'inscrire</button></a></p>
</body>
</html>
