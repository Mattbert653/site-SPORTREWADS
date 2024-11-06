<?php


$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = 'root';
$password = "";

$connexion = new PDO($dsn, $user, $password);

$sql = "SELECT id FROM utilisateur WHERE email=:e AND password=:p";
$resultado = $connexion ->prepare($sql);
$resultado->bindParam(':e', $_POST['loginUsername']);
$resultado->bindParam(':p', $_POST['loginPassword']);
$ok = $resultado->execute();

if($ok){

	if($resultado->rowCount()>0){
		session_start();
		$user = $resultado -> fetch();
		$_SESSION ['utilisateur_id'] = $user['id'];

		header('Location:sport_reward.php'); #REDIRIGE VERS LA PAGE PRINCIPAL ( A CHANGER ?)
	}else{
		echo "Nom ou Mot de passe Incorrecte";
	}

}else{
		echo "Erreur avec la BD";
		
}
?>
