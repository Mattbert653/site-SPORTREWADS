<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fafafa;
        }

        nav {
            background: linear-gradient(to right, #cc7000, #d97700, #e68500, #f29300, #ff9f00, #ffb000);
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

        form {
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
        }

        form input[type="text"],
        form input[type="email"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form input[type="submit"] {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #405de6;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <nav>
        <h1>Sport Reward</h1>
        <a href="sport_reward.php" class="login">Home</a>
    </nav>

    <main>
        <!-- Página de Login -->
        <form id="loginForm" action="connexionUtilisateur.php" method="post">
            <h2>Se connecter</h2>
            <label for="loginUsername">Email:</label>
            <input type="text" id="loginUsername" name="loginUsername" required>

            <label for="loginPassword">Mot de Passe:</label>
            <input type="password" id="loginPassword" name="loginPassword" required>

            <input type="submit" value="Log In">
        </form>

        <!-- Página de Registro -->
        <form id="registerForm" action="inscription.php" method="post">
            <h2>Nouvel Utilisateur</h2>
            <label for="registerUsername">Nom d'utilisateur:</label>
            <input type="text" id="registerUsername" name="registerUsername" required>

            <label for="registeremail">Email:</label>
            <input type="email" id="registeremail" name="registeremail" required>

            <label for="registerPassword">Mot de passe:</label>  
            <input type="password" id="registerPassword" name="registerPassword" required>

       <!-- <label for="confirmPassword">Confirmar Contraseña:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>-->

            <input type="submit" value="S'inscire">
        </form>
    </main>

</body>
</html>
