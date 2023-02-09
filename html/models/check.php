<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="../css/pseudo.css">


</head>

<body>
    <section class="pseudo">
        <form action="../theme.php" method="POST">
            <p> Vous êtes bien <?php echo $_SESSION['pseudo']; ?> </p>
            <button type="submit" class="style_btn"> Oui</button>
        </form>

    </section>

</body>