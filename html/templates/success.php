<?php
session_start();
require_once('model/model.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/success.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .bloc {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin: 20px;
            max-width: 600px;
            text-align: center;
        }

        .font-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .return {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: all 0.2s ease-in-out;
        }

        .return:hover {
            transform: translateY(-2px);
            box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>
    <div class="bloc">
        <h1 class="font-title">Merci pour votre confiance !</h1>
        <p>Vous avez maintenant accès à de nombreuses questions bonus !</p>
        <div class="center">
            <a class="return" href="index.php?accueil">Retour à l'accueil</a>
        </div>
    </div>
</body>

</html>