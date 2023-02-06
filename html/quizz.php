<?php 

require_once 'co.php';
require_once 'menu.php';
require_once 'pseudo.php';

session_start();




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <section class="quiz">
        <form action="reponse.php" methods="post">

        <?php 
            $result = $connexion->query("select PRENOM from CARNET");
            foreach($result as $personne){
                echo "<h3 class='question'>".$personne["PRENOM"]."</h3>";
            }
        
        
        ?>
        </form>
    </section>
</body>
</html>