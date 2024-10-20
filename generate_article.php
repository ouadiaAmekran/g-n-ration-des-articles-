<?php
// Inclure la configuration de la base de données
include 'config.php';

// Votre clé API OpenAI
$api_key = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = trim($_POST['keyword']);

    if (!empty($keyword)) {
        // Appeler l'API GPT pour générer l'article
        $generated_article = generateArticleWithGPT($keyword, $api_key);

        if ($generated_article) {
            // Insérer l'article généré dans la base de données
            try {
                $stmt = $conn->prepare("INSERT INTO articles (titre, contenu, utilisateur_id) VALUES (:titre, :contenu, :utilisateur_id)");
                $stmt->execute([
                    ':titre' => $generated_article['title'],
                    ':contenu' => $generated_article['content'],
                    ':utilisateur_id' => 2 // Remplacer par l'ID réel de l'utilisateur connecté
                ]);

                // Récupérer l'ID de l'article inséré
                $article_id = $conn->lastInsertId();

                // Rediriger vers view_article.php pour afficher l'article généré
                header("Location: view_article.php?id=" . $article_id);
                exit;
            } catch (PDOException $e) {
                echo "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
            }
        } else {
            // Afficher un message d'erreur clair si l'API GPT ne génère pas un article valide
            echo "Erreur : L'API GPT n'a pas pu générer un article valide. Veuillez réessayer plus tard ou vérifier le mot-clé saisi.";
        }
    } else {
        echo "Erreur : Veuillez saisir un mot-clé valide.";
    }
}

// Fonction pour appeler l'API GPT et générer l'article
function generateArticleWithGPT($keyword, $api_key) {
    $url = 'https://api.openai.com/v1/chat/completions';

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'user',
                'content' => "Rédigez un article détaillé en français sur la rentabilité du secteur au Maroc basé sur le mot-clé : {$keyword}."
            ]
        ],
        'temperature' => 0.7, // Contrôle la créativité de la sortie
        'max_tokens' => 500, // Ajustez selon la longueur souhaitée de l'article
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if ($response === false) {
        // Gestion des erreurs de connexion cURL
        echo "Erreur de connexion cURL : " . curl_error($ch);
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    $response_data = json_decode($response, true);

    // Vérifiez si 'choices' existe dans la réponse et accédez au texte généré
    if (isset($response_data['choices'][0]['message']['content'])) {
        return [
            'title' => "Article sur {$keyword}",
            'content' => trim($response_data['choices'][0]['message']['content'])
        ];
    } else {
        // Gestion des erreurs dans la réponse de l'API
        if (isset($response_data['error'])) {
            echo "Erreur de l'API : " . $response_data['error']['message'];
        } else {
            echo "Erreur : Réponse inattendue de l'API. Veuillez réessayer.";
        }
        return false;
    }
}
?>
