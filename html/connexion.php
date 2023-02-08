<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// if (isset($_POST['name']) && ($_POST['name'] != "")) {
//     $_SESSION['pseudo'] = $_POST['name'];
//     echo $_SESSION['pseudo'];
//     header("location:theme.php"); //redirection vers la page theme
// } else {
//     $error = "Veuillez entrer un pseudo";
// }

?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="../css/pseudo.css">


</head>

<body>

    <?php
    include "menu.php";
    include "co.php";
    ?>
    <section class="pseudo">
        <form action="theme.php" method="post">
            <!-- si erreur alors affiche cette div -->
            <?php if (isset($error)) { ?>
                <div class="error">
                    <?php echo $error; ?>
                </div>
            <?php } ?>
            <label>Entrer ton pseudo !</label>
            <!-- si j'ai une session d'ouverte alors je garde le pseudo dans le champ sinon ma value est none-->
            <input type="text" name="name" value="" placeholder="pseudo">
            <label> Entre ton mdp !</label>
            <input type="text" name="mdp" placeholder="mot de passe">
            <button type="submit" class="style_btn"> Enregistrer</button>
        </form>

    </section>




</body>