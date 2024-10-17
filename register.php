<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (nom, prenom, pseudo, email, password, score) VALUES ('$nom', '$prenom', '$pseudo', '$email', '$password', 0)";

    if ($conn->query($sql) === TRUE) {
        echo "Inscription réussie. <a href='login.html'>Connectez-vous ici</a>";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
