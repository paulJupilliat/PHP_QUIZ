<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        <form action="reponse.php" method="post">

        <?php 
            $theme = "Histoire";
            $result = $connexion->query("select * from QUESTION where theme = '$theme'");
            foreach($result as $ques){
                ?>
                <h3 class="question" id=<?=$ques["id_question"] ?>  ><?=$ques["interogation"]?></h3><br><br>
                
                <?php
                $idq = $ques["id_question"];
                $id_ch = $ques["id_choix"];
                $req_choix= "select * from REPONSE where id_choix = $id_ch";
                $reponse_possible = explode(',', $ques["reponse"]);
                foreach($reponse_possible as $rep){
                ?>
                    <div class="reponse">
                        <input type="radio" name="reponse<?=$idq?>" value="<?=$rep?>"> <?=$rep?><br>
                        <input type="radio" name="reponse<?=$idq?>" value="<?=$rep?>"> <?=$rep?><br>
                        <input type="radio" name="reponse<?=$idq?>" value="<?=$rep?>"> <?=$rep?><br>
                        <!-- a changer en fonction des choix et non des reponses -->
                        <br>
                    </div>
                    <?php
                }
            }
        
        ?>
        </form>
    </section>
</body>
</html>