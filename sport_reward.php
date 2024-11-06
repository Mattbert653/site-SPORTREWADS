<?php
session_start();
if (!isset($_SESSION['utilisateur_id'])) {
    header('Location: sr_login.php');
    exit();
}

$dsn = "mysql:host=localhost;dbname=sport_rewards";
$user = 'root';
$password = "";

try {
    // Connexion à la base de données
    $connexion = new PDO($dsn, $user, $password);
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations de l'utilisateur connecté
    $sql = "SELECT nom FROM utilisateur WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['utilisateur_id']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch();
        $nom_utilisateur = $user['nom'];
    } else {
        echo "Utilisateur non trouvé.";
        exit();
    }

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <style>
        /* Inclure le même style que dans index.html */
        body {
            background-color: rgb(250, 250, 250);
            margin: 0;
            font-family: Arial, sans-serif;
            color: black;
        }

        nav {
            background: linear-gradient(to right,  #cc7000, #d97700, #e68500, #f29300, #ff9f00, #ffb000);
            color: #ffffff;
            padding: 10px;
            text-align: left;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav h1 {
            margin: 0;
            font-size: 24px;
        }

        nav .login {
            padding: 8px 16px;
            font-size: 16px;
            background-color: transparent;
            color: #ffffff;
            border: 1px solid #ffffff;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        nav .login:hover {
            background-color: white;
            color: #fd1d1d;
        }

        main {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 2px solid #ddd;
        }

        .profile-section {
            display: flex;
            align-items: center;
        }

        .profile-photo {
            width: 80px;
            height: 80px;
            background-color: #ccc;
            border-radius: 50%;
            margin-right: 20px;
        }

        .score-section {
            text-align: center;
        }

        .score-label {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bar-container {
            position: relative;
            width: 50px;
            height: 200px;
            background: linear-gradient(to top, #e0e0e0, #f8f8f8);
            clip-path: polygon(20% 100%, 80% 100%, 100% 0%, 0% 0%);
            overflow: hidden;
            margin: 0 auto;
        }

        .bar-fill {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(to top, #f47c24, #ff9800, #fdd835, #4cc0a9, #34ebba, #009688);
            transition: height 0.5s ease-in-out;
        }

        main {
            padding: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin: 30px 0 10px;
        }

        .gift-section, .discount-section, .earn-points-section {
            display: flex;
            gap: 20px;
            overflow-x: scroll;
        }

        .gift-item, .discount-item, .earn-item {
            width: 250px;
            height: 250px;
            aspect-ratio: 1 / 1;
            background-color: #f0f0f0;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background-color: white;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid #ddd;
        }

        .bottom-nav img {
            width: 40px;
            height: 40px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav>
        <h1>Sport Reward</h1>    

        <?php
        if (!isset($_SESSION['utilisateur_id'])) {
            echo '<a class="login" href="sr_login.php">Login</a>'; 
        } else {
            echo "Utilisateur " . htmlspecialchars($_SESSION['utilisateur_id']);
            echo "<a class='login' href='FermerSession.php' style='color: #000000;'>Quitter</a>";
        }
        ?>

    </nav>
    <header>
        <div class="profile-section">
            <div class="profile-photo"></div>
            <div>
                <h2><?php echo htmlspecialchars($nom_utilisateur); ?></h2>
            </div>
        </div>
        <div class="score-section">
            <div class="score-label" id="score-label">0 points</div>
            <div class="bar-container">
                <div class="bar-fill" id="bar-fill"></div>
            </div>
        </div>
    </header>

    <main>
        <div class="section-title">BOUTIQUE</div>
        <div class="score-total" style="font-size: 18px; font-weight: bold; margin-bottom: 20px;">NOMBRE DE POINTS: <span id="total-points">0</span></div>
        <div class="section-title">CADEAUX</div>
        <div class="gift-section">
            <div class="gift-item">Photo du cadeau<br>x pts</div>
            <!-- Répéter d'autres items de cadeaux comme nécessaire -->
        </div>

        <div class="section-title">CARTES RÉDUCTIONS</div>
        <div class="discount-section">
            <div class="discount-item">Photo</div>
            <!-- Répéter d'autres items de réductions comme nécessaire -->
        </div>

        <div class="section-title">GAGNEZ DES POINTS</div>
        <div class="earn-points-section">
            <div class="earn-item">Texte</div>
            <!-- Répéter d'autres items de points comme nécessaire -->
        </div>
    </main>

    <div class="bottom-nav">
        <a href="boutique_recompenses.html">
            <img src="shop_icon.png" alt="Boutique">
        </a>
        <a href="ajouter_move.html">
            <img src="add_icon.png" alt="Ajouter Move">
        </a>
        <a href="sport_reward.php">
            <img src="account_icon.png" alt="Compte">
        </a>
    </div>

    <script>
        // Code JavaScript pour afficher le score
        let currentScore = 0;

        const scoreLabel = document.getElementById('score-label');
        const barFill = document.getElementById('bar-fill');

        function updateScoreDisplay(score) {
            scoreLabel.innerText = score + ' points';
            barFill.style.height = Math.min(score / 100 * 200, 200) + 'px';
        }

        // Initialisation de l'affichage du score
        updateScoreDisplay(currentScore);
    </script>
</body>
</html>