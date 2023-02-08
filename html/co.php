<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>
    Ajout de la personne <?php echo $_GET['nom']; ?>
  </title>
 

<body>
  <?php
  $ipAddress = $_SERVER['REMOTE_ADDR'];
  $port = 3306;
  $username = "appadmin";
  $password = "pwdadmin";
  $dbname = "quizz";

  try {
    $conn = new PDO("mysql:host=$ipAddress;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
  }
  ?>
</body>

</html>