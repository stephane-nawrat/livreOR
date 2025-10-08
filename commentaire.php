<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $commentaire = $_POST['commentaire'];
    $id_utilisateur = $_SESSION['login'];

    $conn = new mysqli("localhost", "root", "root", "livreor");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $commentaire, $id_utilisateur);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: livre-or.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ajouter un commentaire</h1>
    <form action="commentaire.php" method="post">
        <label for="commentaire">Commentaire:</label>
        <textarea id="commentaire" name="commentaire" required></textarea>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>