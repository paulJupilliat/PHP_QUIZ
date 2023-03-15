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
<style>
  .tentative {
    border: 1px solid black;
    padding: 10px;
    margin-bottom: 10px;
  }
  .tentative h2 {
    margin-top: 0;
  }
  .score {
    text-align: right;
    margin-bottom: 10px;
  }
  .score h2 {
    margin-top: 0;
    color: #4CAF50;
  }
  .question {
    margin-bottom: 10px;
  }
  .interrogation {
    font-weight: bold;
    margin-bottom: 5px;
  }
  .reponse {
    margin-right: 5px;
  }
  .true {
    color: #4CAF50;
  }
  .false {
    color: #F44336;
  }
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