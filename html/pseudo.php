<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['name']) && ($_POST['name'] != "")) {
    $_SESSION['pseudo'] = $_POST['name'];
    echo $_SESSION['pseudo'];
    header("location:theme.php"); //redirection vers la page theme
} else {
    $error = "Veuillez entrer un pseudo";
}

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
            <p class="error">
                <?php
                // if (isset($error)) {
                //     echo $error; //marche pas car s'affiche tout le temps 
                // }
                ?>
            </p>
            <label>Entrer ton pseudo !</label>
            <!-- si j'ai une session d'ouverte alors je garde le pseudo dans le champ sinon ma value est none-->

            <input type="text" name="name" value="<?php if (isset($_SESSION['pseudo'])) echo $_SESSION['pseudo'] ?>"> <!-- je n'arive pas a gérer le fait que si on ne rentre rien cela retrourne l'erreur creer. le champ de text est a priorie initialisé a 1-->
            <br><br>
            <label > Entre ton mdp !</label>
            <input type="text" name="mdp" >
            <button type="submit" class="style_btn"> Enregistrer</button>
        </form>

    </section>


                

</body>