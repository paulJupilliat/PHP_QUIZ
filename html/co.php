<!doctype html>
<html>
<head>
	<meta charset="utf-8">
<title>
	Ajout de la personne <?php echo $_GET['nom']; ?>
</title>
<body>
<?php
// importer .env

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
$sql="SELECT * from CARNET ";
$stmt=$connexion->prepare($sql);
// $stmt->bindValue(':nom', $_GET['nom']);
// $stmt->bindValue(':prenom', $_GET['prenom']);
// $stmt->bindValue(':naissance', $_GET['naissance']);
$stmt->execute();

if (!$stmt) die("Pb d'accès à la table");
// Si la requête de vérification ne renvoie rien
// il n'existe pas de personne portant ce nom, ce prénom
// et née ce jour là et on effectue l'insertion
else if ($stmt->rowCount()==0){
	$sql="INSERT into CARNET values(0,:nom,:prenom,:naissance,:ville)";
	$stmt=$connexion->prepare($sql);
	$stmt->bindParam(':nom', $_GET['nom']);
	$stmt->bindParam(':prenom', $_GET['prenom']);
	$stmt->bindParam(':naissance', $_GET['naissance']);
	$stmt->bindParam(':ville', $_GET['ville']);
	$stmt->execute();
	if (!$stmt) echo "Pb d'insertion de ".$_GET['nom'];
	else {
	        var_dump($stmt);
		echo $_GET['nom']." insérée en base !";
		//header('Refresh: 1; cartable2.php');
		}
	}
	else { 
		echo "Une personne de même NOM, même prénom et même date de naissance existe deja dans la Base !";
		echo "<br/><a href='addPers.html'> Ajout Personne </a>";
	}
?>
</body>
</html>

.

