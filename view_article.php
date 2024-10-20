<?php
// Inclure la configuration de la base de données
include 'config.php';

if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']);

    // Récupérer l'article depuis la base de données
    try {
        $stmt = $conn->prepare("SELECT titre, contenu FROM articles WHERE id = :id");
        $stmt->execute([':id' => $article_id]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            $titre = htmlspecialchars($article['titre']);
            $contenu = nl2br(htmlspecialchars($article['contenu']));
        } else {
            echo "Article non trouvé.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
} else {
    echo "ID d'article non fourni.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre; ?></title>
</head>
<body>
    <h2><?php echo $titre; ?></h2>
    <p><?php echo $contenu; ?></p>
</body>
</html>
