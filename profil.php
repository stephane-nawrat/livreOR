<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: connexion.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_login = $_POST['new_login'];
    $new_password = $_POST['new_password'];

    $conn = new mysqli("localhost", "root", "root", "livreor");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE utilisateurs SET login = ?, password = ? WHERE login = ?");
    $stmt->bind_param("sss", $new_login, $new_password, $_SESSION['login']);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION['login'] = $new_login;
    header("Location: profil.php");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Modifier le profil</h1>
    <form action="profil.php" method="post">
        <label for="new_login">Nouveau login:</label>
        <input type="text" id="new_login" name="new_login" required>
        <label for="new_password">Nouveau mot de passe:</label>
        <input type="password" id="new_password" name="new_password" required>
        <button type="submit">Modifier</button>
    </form>
</body>
</html>