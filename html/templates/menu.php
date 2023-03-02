<?php
require_once('controllers/controller.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/menu.css">


</head>

<body>
    <ul class="menu">

        <a class="" href="#"> <?php
                                echo $_SESSION['pseudo'];
                                ?></a>
        <a class="navbar_elem" href="#"> Voir les résultats</a>
        <a class="navbar_elem" href="index.php"> Changer de thème</a>
        <?php if (isset($_SESSION['pseudo'])) { ?>
            <a class="navbar_elem" href="index.php?action=logout"> Déconnexion</a>
            <?php
            if (USER::isAdmin($_SESSION['pseudo'])) {
                echo '<a class="navbar_elem" href="index.php?action=admin"> Admin Console</a>';
            }
        } else { ?>
            <a class="navbar_elem" href="index.php?action=login"> Connexion</a>
        <?php } ?>
    </ul>




</body>

</html>