<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['formconnexion']))
{
    $pseudoconnect = htmlspecialchars($_POST['name']);
    $mdpconnect = sha1($_POST['mdp']);
    if (!empty($pseudoconnect) and !empty($mdpconnect));
    {
        $requser = $connexion->query("SELECT * FROM membre WHERE pseudo = ? AND motdepasse = ?");
        $requser->execute(array($pseudoconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if ($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            // $_SESSION['mail'] = $userinfo['mail'];
            header("Location: theme.php");
        }
        else
        {
            $erreur = "Mauvais pseudo ou mot de passe !";
        }
    }

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
        <form action="" method="post">
            <p class="error">
                <?php
                // si mes champs sont vides alors j'affiche un message d'erreur
                if (isset($error)) {
                    echo '<font color ="red">'.$error;
                }
                ?>
            </p>
            <label>Entrer ton pseudo !</label>
            <input type="text" name="name" value="<?php if (isset($_SESSION['pseudo'])) echo $_SESSION['pseudo'] ?>"> 
            <br><br>
            <label > Entre ton mdp !</label>
            <input type="text" name="mdp" >
            <button type="submit" name = "formconnexion" class="style_btn"> Enregistrer</button>
        </form>

    </section>


                

</body>