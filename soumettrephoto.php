<?php /*


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//session_start();

// Etape 1 : Vérifier si l'utilisateur est connecté
//if (!isset($_SESSION['id_usuario'])) {
   // header("Location: sr_login.php");
  //  exit();
//}

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = "root";
$password = "";
$connexion = new PDO($dsn, $user, $password);

// Vérifier la connexion
if (!$connexion) {
    die("Échec de la connexion à la base de données");
}else{
	echo "Connexion réussie";
}

// Etape 2 :Récupérer les réservations de l'utilisateur
$titre = $_POST["title"];

$routeTemporaire = $_FILES["photo"]["tmp_name"];
$routeFinale = "photos/".$_FILES["photo"]["name"];

//Soumettre archive
$ok = move_uploaded_file($routeTemporaire, $routeFinale);

if ($ok) {
    // Si l'envoie s'est bien passé, la publication est envoyée à la base de données
    $sql = "INSERT INTO post (titre, url, utilisateur_id) VALUES (:tit, :url, :u_id)";
    $resultado = $connexion->prepare($sql);
    $resultado ->bindParam(':tit', $titre);
    $resultado ->bindParam(':url', $routeFinale);
   // $resultado ->bindParam(':u_id', '1');
	$ok2 = $resultado->execute();

	if ($ok2) {
		echo'Tout à été envoyé correctement';
	}else{
		echo'Échec de la connexion à la base de données';
}else{
	echo'Erreur d envoie du document';
}




/*$id_usuario = $_SESSION['id_usuario'];
$requete_reservations_utilisateur = $connexion->prepare('SELECT * FROM resa WHERE id_usuario = :id_usuario');
$requete_reservations_utilisateur->bindParam(':id_usuario', $id_usuario);
$requete_reservations_utilisateur->execute();
$reservations_utilisateur = $requete_reservations_utilisateur->fetchAll(PDO::FETCH_ASSOC);
*/
?>
<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//session_start();

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = "root";
$password = "";
$connexion = new PDO($dsn, $user, $password);

if (!$connexion) {
    die("Échec de la connexion à la base de données");
}
/*
// Récupérer le titre
$titre = $_POST["title"];
$routeTemporaire = $_FILES["photo"]["tmp_name"];
$routeFinale = "photos/" . $_FILES["photo"]["name"];

$ok = move_uploaded_file($routeTemporaire, $routeFinale);

if ($ok) {
    $sql = "INSERT INTO post (titre, url, utilisateur_id) VALUES (:tit, :url, :u_id)";
    $resultado = $connexion->prepare($sql);
    $resultado->bindParam(':tit', $titre);
    $resultado->bindParam(':url', $routeFinale);
    $resultado->bindParam(':u_id', 1); // ID utilisateur pour test

    if ($resultado->execute()) {
        echo 'Tout a été envoyé correctement';
    } else {
        echo 'Échec de l\'insertion dans la base de données';
    }
} else {
    echo 'Erreur de l\'envoi du document';
}*/
/*
// Variables pour les paramètres
$titre = $_POST["title"];
$routeFinale = "photos/" . $_FILES["photo"]["name"];
$user_id = 1;  // Remplacez cette valeur par une valeur dynamique selon votre application

// Insertion dans la base de données
$sql = "INSERT INTO post (titre, url, utilisateur_id) VALUES (:tit, :url, :u_id)";
$resultado = $connexion->prepare($sql);
$resultado->bindParam(':tit', $titre);
$resultado->bindParam(':url', $routeFinale);
$resultado->bindParam(':u_id', $user_id);

if ($resultado->execute()) {
    header("Location: sport_reward.php"); // Redirige vers la page principale
    exit();
} else {
    echo 'Échec de l\'insertion dans la base de données';
}
*/
?>





<?php
session_start(); //Pour utiliser $_SESSION[]


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = "root";
$password = "";
$connexion = new PDO($dsn, $user, $password);

if (!$connexion) {
    die("Échec de la connexion à la base de données");
}

// Vérifier si le dossier photos existe, sinon le créer
$dossierPhotos = 'photos/';
if (!is_dir($dossierPhotos)) {
    mkdir($dossierPhotos, 0777, true);
}

// Récupérer le titre et l'image
$titre = $_POST["title"];
$routeTemporaire = $_FILES["photo"]["tmp_name"];
$routeFinale = $dossierPhotos . basename($_FILES["photo"]["name"]);
$user_id = 1;  // Remplacez cette valeur par une valeur dynamique selon votre application

// Déplacer le fichier vers le dossier photos
if (move_uploaded_file($routeTemporaire, $routeFinale)) {
    // Insertion dans la base de données
    $sql = "INSERT INTO post (titre, url, utilisateur_id) VALUES (:tit, :url, :u_id)";
    $resultado = $connexion->prepare($sql);
    $resultado->bindParam(':tit', $titre);
    $resultado->bindParam(':url', $routeFinale);
    $resultado->bindParam(':u_id', $_SESSION['utilisateur_id']);

    if ($resultado->execute()) {
        header("Location: sport_reward.php"); // Redirection vers la page principale
        exit();
    } else {
        echo 'Échec de l\'insertion dans la base de données';
    }
} else {
    echo 'Erreur lors du téléchargement de l\'image';
}
?>