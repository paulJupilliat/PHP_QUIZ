<?php
require('model/connect.php');
/**
 * Connexion à la base de données
 * @return PDO $conn connexion à la base de données
 * @throws PDOException si la connexion échoue
 */
function connexion_to_bd()
{
    try {
        $conn = new PDO("mysql:host=" . SERVEUR . ";dbname=" . BASE . ";port=" . PORT, USER, MDP);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo SERVEUR . "|";
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}

/**
 * Vérifie si l'utilisateur est connecté
 * @return bool true si l'utilisateur est connecté, false sinon
 */
function checkLoged()
{
    return (isset($_SESSION['pseudo']) && $_SESSION['pseudo'] !== '') ? true : false;
}

class User
{
    private $pseudo;
    private $nom;
    private $prenom;
    private $mdp;
    private $age;

    public function __construct($pseudo, $nom, $prenom, $mdp, $age)
    {
        $this->pseudo = $pseudo;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->age = $age;
    }
    /**
     * Check si l'utilisateur existe dans la base de données
     * @param mixed $pseudo pseudo de l'utilisateur
     * @param mixed $mdp mot de passe de l'utilisateur
     * @return int 1 si l'utilisateur existe, 0 si il n'existe pas, -1 si une erreur est survenue, -2 si le mot de passe est incorrect
     */
    public static function checkUser($pseudo, $mdp)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM USERS WHERE pseudo = :pseudo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                if (password_verify($mdp, $result['mdp'])) {
                    return 1;
                } else {
                    return -2;
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        }
        finally {
            $conn = null;
        }
    }

    public static function exist($pseudo)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM USERS WHERE pseudo = :pseudo";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        }
        finally {
            $conn = null;
        }
    }

    public static function isAdmin($pseudo)
    {
        try {
            $conn = connexion_to_bd();
            $sql = "SELECT * FROM have_role WHERE pseudo = :pseudo AND role_name = 'ROLE_ADMIN'";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            // return "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        }
        finally {
            $conn = null;
        }
    }

    /**
     * Ajoute le user dans la base de données
     * @return int 1 si l'utilisateur a été ajouté, -1 si une erreur est survenue, -2 si l'utilisateur existe déjà
     */
    public function pushInBd()
    {
        try {
            $conn = connexion_to_bd();
            if (User::exist($this->pseudo) == 1) {
                return -2;
            }
            $sql = "INSERT INTO USERS (pseudo, nom, prenom, mdp, age) VALUES (:pseudo, :nom, :prenom, :mdp, :age)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->bindParam(':nom', $this->nom);
            $stmt->bindParam(':prenom', $this->prenom);
            $stmt->bindParam(':mdp', password_hash($this->mdp, PASSWORD_DEFAULT));
            $stmt->bindParam(':age', $this->age);
            $stmt->execute();

            // add role user
            $stmt = $conn->prepare("INSERT INTO `have_role` (`pseudo`, `role_name`) VALUES (:pseudo, 'ROLE_USER')");
            $stmt->bindParam(':pseudo', $this->pseudo);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage(); // Pour debug
            return -1;
        }
        finally {
            $conn = null;
        }
    }
}

/*
* Traite le thème qui est envoyé par le formulaire
* @param string $theme le thème à traiter
* @param string otherTheme le thème à traiter si le thème est autre
* @return string le thème traité
*/
function traitementTheme($theme, $otherTheme)
{
    if ($theme == "other") {
        return $otherTheme;
    } else {
        // first letter in uppercase and the rest in lowercase
        return ucfirst(strtolower($theme));
    }
}

/*
* Traite le score du quizz
* @param string $quizz le quizz à traiter
* @return int le score du quizz
*/
function traitementScoreQuizz($quizz){
    $score = 0;
    $parQuestion = explode("*", $quizz);
    // On regarde par question
    foreach ($parQuestion as $question) {
        $interrogation = explode("!", $question)[0]; // On récupère la partie interrogation
        $interrogation = explode(":", $interrogation)[1]; // On récupère la partie l'interrogation
        $interrogation = str_replace("%20", " ", $interrogation);// remplace tous les %20 de l'interrogation par des espaces
        $reponse = explode("!", $question)[1]; // On récupère la partie réponse
        $reponse = explode(":", $reponse)[1]; // On récupère les réponses
        echo $interrogation;
        $questionBd = Question::getByInterrogation("Quel est le nom de la devise de l'Union européenne?");
        // print questionBd dans la console

        // regarde si bon ou non
        if ($questionBd->isTrue($reponse)) {
            $score++;
        }
    }
    return $score;
}
