<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
}

$conn = new mysqli("localhost", "root", "root", "livreor");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT u.login, c.commentaire, c.date FROM commentaires c JOIN utilisateurs u ON c.id_utilisateur = u.id ORDER BY c.date DESC");
$commentaires = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Livre d'or</h1>
    <?php foreach ($commentaires as $commentaire): ?>
        <p>Posté le <?= date('d/m/Y', strtotime($commentaire['date'])) ?> par <?= $commentaire['login'] ?> : <?= $commentaire['commentaire'] ?></p>
    <?php endforeach; ?>
    <a href="commentaire.php">Ajouter un commentaire</a>
</body>
</html>