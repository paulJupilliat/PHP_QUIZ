<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "menu.php";
include "co.php";
session_start();

// if (!isset($_SESSION['pseudo'])) {
//     header("location:pseudo.php"); //si je n'ai pas de session ouverte avec un pseudo je suis redirigé vers la page pseudo
// }
// if (!isset($_SESSION["theme"])) {
//     header("location:theme.php"); //si je n'ai pas de session ouverte avec un theme de qcm je suis redirigé vers la page theme
// }

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
            <form action="reponse.php" method="POST">
                <?php
                    $req = "select PRENOM, ID from CARNET";
                    $stmt = $connexion->prepare($req);
                    
                    //afficher les questions :
                    echo "<ol>"; //permet de mettre les questions dans une liste ordonnée
                    while ($ligne = mysqli_fetch_assoc($res)){
                        $idq = $ligne["ID"];
                        ?>
                        <h3 class="question"><li><?=$ligne["PRENOM"]?></li></h3>
                        <?php
                            $req2 = ("select VILLE from CARNET where ID = $idq");
                            $stmt = $connexion->prepare($req2);
                            while($ligne2 = mysqli_fetch_assoc($res2)){
                                ?>
                                <div class="reponse">
                                    <input type="radio" name="reponse<?=$idq?>" value="<?=$ligne2["VILLE"]?>">
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


