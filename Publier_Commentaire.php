<?php
session_start(); //Pour utiliser $_SESSION[]


// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = "root";
$password = "";

$connexion = new PDO($dsn, $user, $password);

//Recuper les variables

$post_id = $_POST['post'];
$commentaire = $_POST['comment'];
$utilisateur_id = $_SESSION['utilisateur_id'];


//Inserer dans la base de données:
$sql = "INSERT INTO commentaire (commentaire, utilisateur_id, post_id) VALUES (:c, :u, :p)";
    $resultado = $connexion->prepare($sql);
    $resultado->bindParam(':c', $commentaire);
    $resultado->bindParam(':u', $utilisateur_id);
    $resultado->bindParam(':p', $post_id);

    if ($resultado->execute()) {
        header("Location: sport_reward.php"); // Redirection vers la page principale
        exit();
    } else {
        echo 'Erreur de l\'insertion dans la base de données';
    }


?>

