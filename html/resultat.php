<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['pseudo'])) {
    echo 'Bonjour ' . $_SESSION['pseudo'] . ' voici vos resultat du quiz !';
}
$theme = $_GET['theme'];
$score = 0;
$reponse_user = $_POST['reponse'+ $idq];
// je requette la bonne réponse de ma question
// si la bonne réponse est égale à la réponse de l'utilisateur
// alors je lui ajoute un point
// sinon je lui enlève les points si c'est a points négatifs
// je lui affiche son score


?>
<!Doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Resultat</title>
</head>

<body>
    <?php
    $reponse = $connexion->query("select reponse from QUESTION where theme = '$theme'");
    
    ?>
    <section class="result">
        <h3>
            Vous avez effectuer un quiz sur le theme de : <?= $theme ?>
        </h3>
        <h3>
            Ton score est de : <?= $score ?>
    </section>
</body>

</html>