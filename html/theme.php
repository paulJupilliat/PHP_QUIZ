<?php
    if(isset($_POST['btn_theme_1'])){
        echo $_SESSION['pseudo'];
        $_SESSION['theme'] = "CINÉMA"; //on va gerer l'affichage des questions en fonction du theme
        header("location: quiz.php");
    }
?>

<DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    
    <link rel="stylesheet" href="../css/theme.css">


</head>
<body>

    <?php
        include "menu.php"
    ?>
    <form action="theme.php">
        <section class="themes">
            <ul class="list_theme">
                <li> <button name="btn_theme_1" class="style_btn"> CINÉMA</button></li>
                <li> <button name="btn_theme_2" class="style_btn"> SPORT</button></li>
                <li> <button  name="btn_theme_3" class="style_btn"> ART</button></li>
                <li> <button name="btn_theme_4"  class="style_btn"> HISOIRE</button></li>
                <li> <button name="btn_theme_5" class="style_btn"> PSYCHOLOGIE</button></li>
                <li> <button name="btn_theme_6" class="style_btn"> AUTOMOBILE</button></li>
            </ul>
        </section>
    </form>