<?php
    session_start();
    if (isset($_POST['button'])) {
        if (empty($_POST['pseudo'])) {
            $error = "Veuillez entrer un pseudo";
        } 
        else {
            
        }  
    }
   
?>
<DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/navbar.css">


</head>
<body>

    <ul class="menu">
        <a class="navbar_elem" href="#"> Refaire le QCM</a>
        <a class="navbar_elem" href="#"> Voir les résultats</a>
        <a class="navbar_elem" href="#"> Changer de thème</a>
        <a class="navbar_elem" href="#"> Changer de pseudo</a>
    </ul>
    

    
</body>
