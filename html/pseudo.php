<?php
    session_start();
    if (isset($_POST['button'])) {
        if (isset($_POST['name']) && ($_POST['name'] != "")){
            $_SESSION['pseudo'] = $_POST['name'];
            header("location:theme.php"); //redirection vers la page d'accueil
        }
            
    
    else {
            $error = "Veuillez entrer un pseudo";     
    }
    }
?>
<DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    
    <link rel="stylesheet" href="../css/pseudo.css">


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
        <!-- si j'ai une session d'ouverte alors je garde le pseudo dans le champ sinon ma value est none-->
        
        <input type="text" name ="name" value="<?php if(isset($_SESSION['pseudo'])) echo $_SESSION['pseudo'] ?>"> <!-- je n'arive pas a gérer le fait que si on ne rentre rien cela retrourne l'erreur creer. le champ de text est a priorie initialisé a 1-->
        <button class="style_btn" name="button"> Enregistrer</button>
    </form>

    </section>
    

    
</body>
