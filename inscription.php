<?php
// Activer l'affichage des erreurs pour déboguer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = 'root';
$password = "";

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO($dsn, $user, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer les données du formulaire
$nom = $_POST["registerUsername"];
$email = $_POST["registeremail"];
$password = $_POST["registerPassword"];

// Hachage du mot de passe avant de le stocker
#$password_hashed = password_hash($password, PASSWORD_DEFAULT);

try {
    // Préparation et exécution de la requête d'insertion
    $sql = "INSERT INTO utilisateur (nom, email, password) VALUES (:n, :e, :p)";
    $resultado = $connexion->prepare($sql);
    $resultado->bindParam(':n', $nom);
    $resultado->bindParam(':e', $email);
    $resultado->bindParam(':p', $password);

    if ($resultado->execute()) {
        // Redirection avec un paramètre de confirmation
        header('Location: sr_login.php?info=UserOK');
        exit();
    } else {
        echo "Erreur lors de la création de l'utilisateur";
    }
} catch (PDOException $e) {
    // Afficher un message d'erreur détaillé en cas d'échec de la requête
    echo "Erreur de requête : " . $e->getMessage();
}
?>

<?php /*
if ($resultado->execute()) {
    if($resultado->rowCount()>0){
		$user = $resultado -> fetch();
		session_start();
		$_SESSION ['utilisateur_id'] = $user['id'];

		header('Location:sport_reward.php');
	}else{
		header('Location:sr_login.php');
} else {
    echo "Erreur lors de la création de l'utilisateur";
}
*/
?>