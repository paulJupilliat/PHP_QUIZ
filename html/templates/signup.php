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
            echo '<div class="error">
                <p><?php echo $err; ?></p>
            </div>';
        } ?>
        <form method="post" action="index.php">
            <div>
                <input type="hidden" name="action" value="newsignup"> <!-- Permet d'envoyer l'action -->
                <label> Pseudo </label>
                <input type="text" name="pseudo" value="" placeholder="pseudo" required>
                <label> Mote de passe</label>
                <input type="password" name="mdp" placeholder="mot de passe">
                <label> Confirmation mot de passe</label>
                <input type="password" name="mdp2" placeholder="confirmer mot de passe">
            </div>
            <div>
                <label> Nom</label>
                <input type="text" name="nom" placeholder="nom">
                <label> Prénom</label>
                <input type="text" name="prenom" placeholder="prenom">
                <label> age</label>
                <input type="number" name="age" placeholder="age">
            </div>
            <button type="submit" class="style_btn"> Signup</button>
        </form>
    </section>

</body>