<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/menu.css">


</head>

<body>
    <ul class="menu">

        <a class="navbar_elem" href="#"> Voir les résultats</a>
        <a class="navbar_elem" href="#"> Changer de thème</a>
        <?php if (isset($_SESSION['pseudo'])) { ?>
            <a class="navbar_elem" href="index.php?action=logout"> Déconnexion</a>
        <?php } else { ?>
            <a class="navbar_elem" href="index.php?action=login"> Connexion</a>
        <?php } ?>
    </ul>




</body>

</html>
