<?php
    session_start();
    if (isset($_POST['button'])) {
        if (empty($_POST['pseudo'])){
            $error = "Veuillez entrer un pseudo";
        } 
        else {
            $_SESSION['pseudo'] = $_POST['pseudo']; //création de la session car le pseudo est valide
            header("location: theme.php"); //redirection vers la page d'accueil

            
        }  
    }
   
?>
<DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="../css/navbar.css">


</head>
<body>

    <?php
        include "menu.php"
    ?>
    <section class="pseudo">
    <form action="pseudo.php" method = "POST">
        <p class ="error">
            <?php
                if (isset($error)) {
                    echo $error;
                }
            ?>
        </p>
        <label>Entrer votre pseudo !</label>
        <input type="text" placeholder = "ex: Fred">
        <button class="style_btn"> Enregistrer</button>
    </form>

    </section>
    

    
</body>
