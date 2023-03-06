<?php
if (isset($_SESSION['pseudo'])) {
    echo 'Bonjour ' . $_SESSION['pseudo'] . ' voici vos resultat du quiz !';
}
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
            Vous avez effectuer un quiz sur le theme de : <?= $_SESSION['theme'] ?>
        </h3>
        <h3>
            Vous avez repondu correctement a : <?= $_SESSION['score'] ?> questions
    </section>
</body>

</html>