<?php
session_start();
if (isset($_SESSION['pseudo'])) {
    echo 'Bonjour ' . $_SESSION['pseudo'] . ' voici vos resultat du quiz !';
}
$theme = $_GET['theme'];
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
al
<body>
    <section class="result">
        <h3>
            Vous avez effectuer un quiz sur le theme de : <?= $theme ?>
        </h3>
        <h3>
            Vous avez repondu correctement a : <?= $_SESSION['score'] ?> questions
    </section>
</body>

</html>