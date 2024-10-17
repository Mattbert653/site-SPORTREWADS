<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Move</title>
    <style>
        body {
            background-color: rgb(248, 190, 114);
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: white;
            text-align: center;
            position: relative;
        }

        video {
            border: 2px solid white;
            margin-bottom: 20px;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            object-fit: cover;
            z-index: 1;
        }

        .overlay {
            position: relative;
            z-index: 2;
        }

        .photo-upload {
            width: 80px;
            height: 80px;
            background-color: transparent;
            border: 8px solid white;
            border-radius: 50%;
            position: fixed;
            bottom: 10%;
            left: 50%;
            transform: translateX(-50%);
            cursor: pointer;
            z-index: 2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .photo-display {
            margin: 20px;
            border: 2px solid white;
            display: none;
            max-width: 100%;
            max-height: 80vh;
            position: relative;
            z-index: 2;
        }

        .loading {
            display: none;
            font-size: 2em;
            margin: 20px;
            position: relative;
            z-index: 2;
        }

        .message {
            font-size: 2em;
            margin-top: 20px;
            visibility: hidden;
            position: relative;
            z-index: 2;
        }

        .tirelire {
            font-size: 3em;
            margin-top: 20px;
            visibility: hidden;
            position: relative;
            z-index: 2;
        }

        .confirm-btn, .retry-btn, .back-btn {
            margin: 10px;
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.2em;
            cursor: pointer;
            transition: background-color 0.3s;
            position: relative;
            z-index: 2;
        }

        .confirm-btn:hover, .back-btn:hover {
            background-color: #218838;
        }

        .retry-btn {
            background-color: #dc3545;
        }

        .retry-btn:hover {
            background-color: #c82333;
        }

        .back-btn {
            display: block;
            margin: 20px auto; /* Centre horizontalement le bouton retour au menu */
        }

        @media (max-width: 600px) {
            .photo-upload {
                width: 70px;
                height: 70px;
                border: 6px solid white;
            }

            video {
                max-height: 100%;
            }
        }
    </style>
</head>

<body>
    <video id="video" autoplay></video>
    <div class="overlay">
        <button class="photo-upload" id="capture-btn"></button>

        <canvas id="canvas" style="display: none;"></canvas>
        <img id="photo-display" class="photo-display" alt="Photo capturée">

        <div class="loading" id="loading">Chargement...</div>
        <div class="message" id="message">Bravo ! À demain !</div>
        <div class="tirelire" id="tirelire">💰 20 points</div>

        <div id="confirmation-modal" style="display: none;">
            <h2>Confirmez votre photo</h2>
            <button class="confirm-btn" id="confirm-btn">Confirmer</button>
            <button class="retry-btn" id="retry-btn">Reprendre</button>
        </div>

        <button class="back-btn" id="back-btn" style="display: none;">Retour au menu</button>
    </div>

    <script>
        // Injection de l'ID utilisateur côté client
        <?php if (isset($_SESSION['user_id'])): ?>
            const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
        <?php else: ?>
            const userId = null;
        <?php endif; ?>

        if (!userId) {
            alert("Veuillez vous connecter pour ajouter un move.");
            window.location.href = "login.html";
        }

        const video = document.getElementById('video');
        const captureButton = document.getElementById('capture-btn');
        const loadingMessage = document.getElementById('loading');
        const message = document.getElementById('message');
        const tirelire = document.getElementById('tirelire');
        const photoDisplay = document.getElementById('photo-display');
        const confirmationModal = document.getElementById('confirmation-modal');
        const confirmButton = document.getElementById('confirm-btn');
        const retryButton = document.getElementById('retry-btn');
        const backButton = document.getElementById('back-btn');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((error) => {
                console.error("Erreur d'accès à la caméra:", error);
            });

        captureButton.addEventListener('click', () => {
            const canvas = document.getElementById('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL('image/png');
            photoDisplay.src = dataURL;
            photoDisplay.style.display = 'block';

            video.style.display = 'none';
            captureButton.style.display = 'none';
            confirmationModal.style.display = 'block';
        });

        confirmButton.addEventListener('click', () => {
            loadingMessage.style.display = 'block';
            confirmationModal.style.display = 'none';

            // Mise à jour du score via la requête PHP
            fetch('update_score.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: userId, points: 20 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    message.style.visibility = 'visible';
                    tirelire.style.visibility = 'visible';
                }
                loadingMessage.style.display = 'none';

                setTimeout(() => {
                    message.innerText = "Bravo ! Votre photo a été ajoutée.";
                    backButton.style.display = 'block';
                }, 2000);
            })
            .catch(error => {
                console.error("Erreur lors de la mise à jour du score:", error);
            });
        });

        retryButton.addEventListener('click', () => {
            photoDisplay.style.display = 'none';
            video.style.display = 'block';
            captureButton.style.display = 'block';
            confirmationModal.style.display = 'none';
        });

        backButton.addEventListener('click', () => {
            window.location.href = "index.html";
        });
    </script>
</body>
</html>

