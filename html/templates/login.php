<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/pseudo.css">


</head>

<body>

    <?php
    include "menu.php";
    ?>
    <section class="pseudo">
        <?php if (isset($err)) {
            if ($err == "Pseudo incorrect") {
                echo '<div class="error">
                <p><?php echo $err; ?></p>
                <a href="index.php?action=signup">Créer un compte</a>
            </div>
            ';
            } else {

                echo '<div class="error">
                <p><?php echo $err; ?></p>
            </div>';
            }
        } ?>
        <form method="get" action="index.php">
            <input type="hidden" name="action" value="connexion"> <!-- Permet d'envoyer l'action -->
            <label>Entrer ton pseudo !</label>
            <input type="text" name="name" value="" placeholder="pseudo" required>
            <label> Entre ton mdp !</label>
            <input type="text" name="mdp" placeholder="mot de passe" required>
            <button type="submit" class="style_btn"> Enregistrer</button>
        </form>
    </section>




</body>