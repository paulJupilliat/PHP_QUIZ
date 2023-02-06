<!doctype html>
<html>
<head>
	<meta charset="utf-8">
<title>
	Ajout de la personne <?php echo $_GET['nom']; ?>
</title>
<body>
<?php


$dsn="mysql:dbname=PAULDB;host=localhost";
    try{
      $connexion=new PDO($dsn,"paul","paul");
      $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch(PDOException $e){
      printf("Échec de la connexion : %s\n", $e->getMessage());
      exit();
    }
// Vérification préalable à l'insertion en Base

// $sql="SELECT * from CARNET ";
// $stmt=$connexion->prepare($sql);

// $stmt->execute();


// if (!$stmt) die("Pb d'accès à la table");

// ?>
</body>
</html>


