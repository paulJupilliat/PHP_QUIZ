<?php
session_start();
// je modifie mon utilisateur dans la base de données pour le faire passer prenium

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/success.css">
</head>
<body>

<div class="bloc">
    <div class="success-logo">
        <img src="assets/img/checked.png">
    </div>
    <h1 class="font-title">Merci pour votre confiance !</h1>
    <p>Veuillez joindre vos fichiers au format .zip</p>
    <div class="center">
        <a class="return" href="index.php?accueil">Retour à l'accueil</a>
    </div>
</div>

</body>
</html>