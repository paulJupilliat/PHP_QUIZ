<?php
    
    if(isset($_POST['btn_theme_1'])){ // si on clique sur le bouton du theme 1
        $_SESSION['theme'] = "CINÉMA"; //on va gerer l'affichage des questions en fonction du theme
        header("location: quizz.php");
    }
    if(isset($_POST['btn_theme_2'])){
        $_SESSION['theme'] = "SPORT";
        header("location: quizz.php");
    }
    if(isset($_POST['btn_theme_3'])){
        $_SESSION['theme'] = "ART";
        header("location: quizz.php");
    }
    if(isset($_POST['btn_theme_4'])){
        $_SESSION['theme'] = "HISTOIRE";
        header("location: quizz.php");
    }
    if(isset($_POST['btn_theme_5'])){
        $_SESSION['theme'] = "PSYCHOLOGIE";
        header("location: quizz.php");
    }
    if(isset($_POST['btn_theme_6'])){
        $_SESSION['theme'] = "AUTOMOBILE";
        header("location: quizz.php");
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
        include "menu.php";
    ?>

    <form action="quizz.php" method="POST">
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